<?php

namespace App\Http\Controllers;

use App\Repositories\GiftCertificateRepository;
use Illuminate\Http\Request;

class PaypalPaymentController extends Controller
{

    protected $giftCertificateRepository;

    protected $paypalApiUrl;
    protected $clientId;
    protected $clientSecret;

    public function __construct(GiftCertificateRepository $giftCertificateRepository)
    {
        $mode = config('paypal.mode');
        if ($mode == 'sandbox') {
            $this->paypalApiUrl = 'https://api-m.sandbox.paypal.com';
            $this->clientId = config('paypal.sandbox.client_id');
            $this->clientSecret = config('paypal.sandbox.client_secret');
        } else {
            $this->paypalApiUrl = 'https://api-m.paypal.com';
            $this->clientId = config('paypal.live.client_id');
            $this->clientSecret = config('paypal.live.client_secret');
        }

        $config = 'paypal.' . $mode . '.client';
        $this->giftCertificateRepository = $giftCertificateRepository;
    }

    private function getAccessToken()
    {
        // initialize CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->paypalApiUrl . '/v1/oauth2/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_USERPWD,  $this->clientId . ':' . $this->clientSecret);

        // set headers
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Accept-Language: en_US';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo json_encode([
                "status" => "error",
                "message" => curl_error($ch)
            ]);
            exit();
        }
        curl_close($ch);
        $result = json_decode($result, true);
        return $result['access_token'];
    }

    private function createOrder($authToken, $gift)
    {
        $gift = $this->giftCertificateRepository->getById(session('giftCertificateId'));
        $data = '{
            "intent": "CAPTURE",
            "purchase_units": [
                {
                    "amount": {
                        "currency_code": "GBP",
                        "value": ' . $gift->gift_amount . '
                    }
                }
            ]
        }';

        // initialize CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->paypalApiUrl . '/v2/checkout/orders');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // set headers
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $authToken;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo json_encode([
                "status" => "error",
                "message" => curl_error($ch)
            ]);
            exit();
        }
        curl_close($ch);

        return json_decode($result, true);
    }

    public function create(Request $request)
    {
        $gift = $this->giftCertificateRepository->getById(session('giftCertificateId'));
        $authToken = $this->getAccessToken();
        $order = $this->createOrder($authToken, $gift);
        return response()->json($order);
    }

    public function capture(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $authToken = $this->getAccessToken();

        // initialize CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->paypalApiUrl . '/v2/checkout/orders/' . $data['orderID'] . '/capture');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // set headers
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer ' . $authToken;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            echo json_encode([
                "status" => "error",
                "message" => curl_error($ch)
            ]);
            exit();
        }
        curl_close($ch);

        return json_decode($result, true);
    }
}

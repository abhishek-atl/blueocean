<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGiftCertificateRequestCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

use App\Repositories\GiftCertificateRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\TariffPlanRepository;

use App\Services\FormatService;
use App\Services\MailService;

class GiftVoucherController extends Controller
{
    protected GiftCertificateRepository $giftCertificateRepository;
    protected PaymentRepository $paymentRepository;
    protected TariffPlanRepository $tariffPlanRepository;
    protected FormatService $formatService;
    protected MailService $mailService;

    public function __construct(
        GiftCertificateRepository $giftCertificateRepository,
        PaymentRepository $paymentRepository,
        TariffPlanRepository $tariffPlanRepository,
        FormatService $formatService,
        MailService $mailService

    ) {
        $this->giftCertificateRepository = $giftCertificateRepository;
        $this->paymentRepository = $paymentRepository;
        $this->tariffPlanRepository = $tariffPlanRepository;
        $this->formatService = $formatService;
        $this->mailService = $mailService;
    }

    public function gifts(Request $request)
    {
        $request->session()->forget('giftCertificateId');
        $tariffs = $this->tariffPlanRepository->getByParams();
        return view('frontend.modules.gifts.form', [
            'tariff' =>  $tariffs
        ]);
    }

    public function giftsPost(StoreGiftCertificateRequestCustomer $request)
    {
        $params = $request->validated();
        $params['remaining_amount'] = $request->gift_amount;
        $params['used_amount'] = 0;
        $params['gift_code'] = Str::random();
        $params['payment_status'] = 'in_progress';
        $params['payment_method'] = 'stripe';
        $params['message'] = $request->message;
        if (isset($request->send_at) && $request->sendtime == 'later') {
            $params['send_at'] = Carbon::createFromFormat(config('custom.format.date_short'), $request->send_at);
            $params['expire_at'] = Carbon::createFromFormat(config('custom.format.date_short'), $request->send_at)->addYear();
        } else {
            $params['send_at'] = null;
            $params['expire_at'] = Carbon::now()->addYear();
        }
        $giftCertificate = $this->giftCertificateRepository->save($params);
        session(['giftCertificateId' => $giftCertificate->id]);
        return redirect()->route('gifts_payment');
    }

    public function giftsPayment(Request $request)
    {
        if (!$request->session()->has('giftCertificateId')) {
            return redirect(route('gifts'));
        }
        return view('frontend.modules.gifts.payment', [
            'spk' => config('custom.stripe_public_key'),
        ]);
    }

    public function giftsPaymentPost(Request $request)
    {
        $gift = $this->giftCertificateRepository->getById(session('giftCertificateId'));
        $productName = 'Gift Card';
        $amount = $gift->gift_amount;
        $customerEmail = $gift->sender_email;

        $successUrl = route('gifts_payment_stripe_return') . '?session_id={CHECKOUT_SESSION_ID}';
        $cancelUrl = route('gifts');
        \Stripe\Stripe::setApiKey(config('custom.stripe_secret_key'));
        $stripeSession = $this->paymentRepository->createStripeSession($productName, $amount, $customerEmail, $successUrl, $cancelUrl);
        return response()->json($stripeSession);
    }

    public function giftsPaymentStripeReturn(Request $request)
    {
        if (!$request->session()->has('giftCertificateId')) {
            return redirect(route('gifts'));
        }

        \Stripe\Stripe::setApiKey(config('custom.stripe_secret_key'));
        $stripeSession = \Stripe\Checkout\Session::retrieve($request->session_id);

        if ($stripeSession->payment_status == 'paid') {

            $giftCertificate = $this->giftCertificateRepository->getById($request->session()->get('giftCertificateId'));
            $giftCertificate->payment_status = 'paid';
            $giftCertificate->charge_id = $stripeSession->payment_intent;
            $giftCertificate->save();

            $this->mailService->sendMailGiftCertificateAdmin($giftCertificate);
            $this->mailService->sendMailGiftCertificateSender($giftCertificate);
            if (!$giftCertificate->send_at) {
                $this->mailService->sendMailGiftCertificateRecipient($giftCertificate);
                return redirect(route('gifts_payment_success'))->with('success', 'Payment successful');
            } else {
                return redirect(route('gifts_payment_success'))->with('success', 'Payment successful');
            }
        }
    }

    public function giftsPaymentPaypalReturn(Request $request)
    {
        if (!$request->session()->has('giftCertificateId')) {
            return redirect(route('gifts'));
        }
        $giftCertificate = $this->giftCertificateRepository->getById($request->session()->get('giftCertificateId'));
        $giftCertificate->payment_status = 'paid';
        $giftCertificate->payment_method = 'paypal';
        $giftCertificate->charge_id = $request->order_id;
        $giftCertificate->save();

        $this->mailService->sendMailGiftCertificateAdmin($giftCertificate);
        $this->mailService->sendMailGiftCertificateSender($giftCertificate);
        if (!$giftCertificate->send_at) {
            $this->mailService->sendMailGiftCertificateRecipient($giftCertificate);
            return redirect(route('gifts_payment_success'))->with('success', 'Payment successful');
        } else {
            return redirect(route('gifts_payment_success'))->with('success', 'Payment successful');
        }
    }

    public function giftsPaymentSuccess(Request $request)
    {
        if (!$request->session()->has('giftCertificateId')) {
            return redirect(route('gifts'));
        }
        $giftCertificate = $this->giftCertificateRepository->getById($request->session()->get('giftCertificateId'));
        return view('frontend.modules.gifts.success', [
            'giftCertificate' => $giftCertificate,
        ]);
    }

    public function giftsPaymentPrint(Request $request)
    {
        $giftCertificate = $this->giftCertificateRepository->getById($request->id);
        return view('frontend.modules.gifts.print', [
            'giftCertificate' => $giftCertificate,
        ]);
    }
}

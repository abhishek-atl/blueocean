<?php


namespace App\Repositories;

use App\Models\Payment;
use App\Models\PaymentReceived;
use App\Models\TherapistsMandate;
use App\Repositories\BaseRepository;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class PaymentRepository extends BaseRepository
{
    protected $payment;
    protected $therapistsMandate;

    public function __construct(
        Payment $payment,
        TherapistsMandate $therapistsMandate
    ) {
        parent::__construct($payment);
        $this->payment = $payment;
        $this->therapistsMandate = $therapistsMandate;
    }

    function checkoutSessionCompleted($session)
    {
        $stripe = new \Stripe\StripeClient(config('custom.stripe_secret_key'));
        $checkoutSession = $stripe->checkout->sessions->retrieve($session->id, ['expand' => ['setup_intent']]);
        if ($checkoutSession && $checkoutSession->setup_intent && $checkoutSession->setup_intent->payment_method) {
            $paymentMethod = $stripe->customers->retrievePaymentMethod(
                $checkoutSession->customer,
                $checkoutSession->setup_intent->payment_method,
                []
            );
            $mandate = $stripe->mandates->retrieve($checkoutSession->setup_intent->mandate, []);
            $this->therapistsMandate::where('stripe_customer_id', $checkoutSession->customer)->update([
                'setup_intent_id' => $checkoutSession->setup_intent->id,
                'payment_method_id' => $checkoutSession->setup_intent->payment_method,
                'mandate_id' => $checkoutSession->setup_intent->mandate,
                'bank_last_four_digits' => $paymentMethod->bacs_debit->last4,
                'stripe_status' => $mandate->status,
            ]);
        }
    }

    public function updateMandateStatus($paymentIntent)
    {
        $result = TherapistsMandate::where('mandate_id', $paymentIntent->id)->update([
            'stripe_status' => $paymentIntent->status,
        ]);
        return $result;
    }

    public function paymentStatus($charge)
    {
        $is_settled = 0;
        if ($charge->status == 'succeeded') {
            $is_settled = 1;
        }
        $result = PaymentReceived::where('stripe_payment_id', $charge->payment_intent)->update([
            'status' => $charge->status,
            'is_settled' => $is_settled
        ]);
        return $result;
    }

    public function paymentStatusfailed($charge)
    {
        $result = PaymentReceived::where('stripe_payment_id', $charge->payment_intent)->update([
            'stripe_code' => $charge->failure_code,
            'status' => $charge->status,
            'is_settled' => 0
        ]);
        return $result;
    }
    
    public function paymentDisputeCreated($dispute)
    {
        $result = PaymentReceived::where('stripe_payment_id', $dispute->payment_intent)->update([
            'stripe_code' => $dispute->reason,
            'status' => 'disputed',
            'is_settled' => 0
        ]);
        return $result;
    }

    function createStripeCustomer($user)
    {
        if ($user->mandate && $user->mandate->stripe_customer_id) {
            $stripeCustomer = $this->retrieveStripeCustomer($user->mandate->stripe_customer_id);
            if ($stripeCustomer) {
                return $stripeCustomer;
            }
        }
        $object = [
            'name' => $user->first_name . ' ' . $user->last_name,
            'email' => $user->email
        ];
        $stripe = new \Stripe\StripeClient(config('custom.stripe_secret_key'));
        $response = $stripe->customers->create($object);
        $user->mandate()->create([
            'user_id' => $user->id,
            'therapist_id' => $user->therapist->id,
            'stripe_customer_id' => $response->id,
            'stripe_status' => 'pending'
        ]);
        return $response;
    }

    function retrieveStripeCustomer($stripe_customer_id)
    {
        $stripe = new \Stripe\StripeClient(config('custom.stripe_secret_key'));
        $customer = $stripe->customers->retrieve($stripe_customer_id, []);
        return $customer;
    }

    public function createStripeSession($productName, $amount, $customerEmail, $successUrl, $cancelUrl, $metadata = [])
    {
        \Stripe\Stripe::setApiKey(config('custom.stripe_secret_key'));

        $session = \Stripe\Checkout\Session::create([
            'billing_address_collection' => 'auto',
            //'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => $productName,
                        'images' => ['https://www.themassagerooms.com/assets/img/logo.png']
                    ],
                    'unit_amount' => (int) ($amount * 100),
                ],
                'quantity' => 1,
            ]],
            'customer_email' => $customerEmail,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'payment_intent_data' => [
                'metadata' => $metadata
            ]
        ]);
        return [
            'success' => true,
            'session' => $session
        ];
    }
}

<?php


namespace App\Repositories;

use App\Models\GiftCertificate;
use App\Repositories\BaseRepository;

class GiftCertificateRepository extends BaseRepository
{
    protected $giftCertificate;

    public function __construct(
        GiftCertificate $giftCertificate
    ) {
        parent::__construct($giftCertificate);
        $this->giftCertificate = $giftCertificate;
    }


    public function checkGiftCode($totalCost, $giftcode)
    {
        $params = [];
        $params['where'] = [
            'gift_code' => $giftcode,
            'payment_status' => 'paid'
        ];
        $giftCode = $this->getByParams($params)->first();

        if (
            ($giftCode && $giftCode->remaining_amount > 0 && $giftCode->expire_at > now()) &&
            (!$giftCode->send_at || ($giftCode->send_at && $giftCode->send_at < now()))
        ) {
            $remainingAmount = $giftCode->remaining_amount;
            if ($totalCost <= $remainingAmount) {
                $message = 'Gift code applied successfully for £' . number_format($totalCost, 2) . '.';
                $message .= ' You will have £' . number_format($remainingAmount - $totalCost, 2) . ' balance left.';
                $giftVoucherAmount = $totalCost;
            } else if ($totalCost >= $remainingAmount) {
                $message = 'Gift code applied successfully for £' . number_format($remainingAmount, 2) . '.';
                $message .= ' Please pay remaining amount of £' . number_format($totalCost - $remainingAmount, 2) . ' by Stripe.';
                $giftVoucherAmount = $remainingAmount;
            }
            return [
                'success' => true,
                'discountAmount' => $giftVoucherAmount,
                'message' => $message
            ];
        } else {
            $message = 'Not a valid gift card code.';
            return [
                'success' => false,
                'discountAmount' => 0,
                'message' => $message
            ];
        }
    }
}

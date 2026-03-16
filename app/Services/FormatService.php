<?php

namespace App\Services;

use Illuminate\Support\Carbon;

class FormatService
{

    public function date($date, $format = null)
    {
        if ($format)
            return Carbon::createFromDate($date)->format($format);
        else
            return Carbon::createFromDate($date)->format(config('custom.format.date_short'));
    }

    public function time($date)
    {
        return Carbon::createFromDate($date)->format(config('custom.format.time'));
    }

    public function dec_number($number)
    {
        return number_format($number, 2);
    }

    public function currency($amount)
    {
        return '£' . number_format($amount, 2);
    }

    public function parseFloat($val)
    {
        return (float) filter_var($val, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}

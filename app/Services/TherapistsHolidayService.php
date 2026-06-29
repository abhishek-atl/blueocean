<?php


namespace App\Services;

use App\Models\TherapistsHoliday;
use App\Services\BaseService;

class TherapistsHolidayService extends BaseService
{
    protected $therapistsHoliday;

    public function __construct(
        TherapistsHoliday $therapistsHoliday
    ) {
        parent::__construct($therapistsHoliday);
        $this->therapistsHoliday = $therapistsHoliday;
    }
}

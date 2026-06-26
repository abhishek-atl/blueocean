<?php


namespace App\Services;

use App\Models\TariffPlan;

class TariffPlanService extends BaseService
{

    protected $tariffPlan;

    public function __construct(TariffPlan $tariffPlan)
    {
        parent::__construct($tariffPlan);
        $this->tariffPlan = $tariffPlan;
    }
}

<?php


namespace App\Services;

use App\Models\TariffPlan;
use App\Repositories\BaseRepository;

class TariffPlanService extends BaseRepository
{

    protected $tariffPlan;

    public function __construct(TariffPlan $tariffPlan)
    {
        parent::__construct($tariffPlan);
        $this->tariffPlan = $tariffPlan;
    }
}

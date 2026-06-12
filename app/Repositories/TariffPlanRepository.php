<?php


namespace App\Repositories;

use App\Models\TariffPlan;
use App\Repositories\BaseRepository;

class TariffPlanRepository extends BaseRepository
{

    protected $tariffPlan;

    public function __construct(TariffPlan $tariffPlan)
    {
        parent::__construct($tariffPlan);
        $this->tariffPlan = $tariffPlan;
    }
}

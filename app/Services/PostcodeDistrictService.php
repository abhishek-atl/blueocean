<?php


namespace App\Services;

use App\Models\PostcodeDistrict;
use App\Services\BaseService;

class PostcodeDistrictService extends BaseService
{
    protected $postcodeDistrict;

    public function __construct(
        PostcodeDistrict $postcodeDistrict
    ) {
        parent::__construct($postcodeDistrict);
        $this->postcodeDistrict = $postcodeDistrict;
    }
}

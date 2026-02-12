<?php

namespace App\Repositories\Postcode;

use App\Models\Postcode;
use App\Models\PostcodeZone;
use App\Models\PostDistrict;
use App\Repositories\BaseRepository;

class PostcodeRepository extends BaseRepository
{

    protected $model;

    public function __construct(Postcode $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getPaginated()
    {
        return $this->model::with('district')->paginate(15);
    }

    public function districts()
    {
        return PostDistrict::paginate();
    }

    public function zone($id)
    {
        return PostcodeZone::find($id);
    }

    public function zones()
    {
        return PostcodeZone::paginate(15);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Postcode\PostcodeRepository;
use Illuminate\Http\Request;

class PostcodeController extends Controller
{

    protected $postcodeRepository;

    public function __construct(PostcodeRepository $postcodeRepository)
    {
        $this->postcodeRepository = $postcodeRepository;
    }

    public function index()
    {
        $postcodes = $this->postcodeRepository->getPaginated();
        return view(
            'admin.modules.postcode.index',
            ['postcodes' => $postcodes, 'permissions' => []]
        );
    }

    public function districts()
    {
        $districts = $this->postcodeRepository->districts();
        return view('admin.modules.postcode.districts', ['districts' => $districts]);
    }

    public function zones()
    {
        $zones = $this->postcodeRepository->zones();
        return view('admin.modules.postcode.zones', ['zones' => $zones]);
    }

    public function postcodeZoneAdd(Request $request)
    {
        $isEdit = false;
        $postcodeZone = [];
        if (request('id')) {
            $isEdit = true;
            $postcodeZone = $this->postcodeRepository->zone(request('id'));
            $postcodeZone->load(['postcodes']);
        }

        $districts = $this->postcodeRepository->districts();
        $districts->load('postcodes');

        return view('admin.modules.postcode.zone_add', [
            'isEdit' => $isEdit,
            'postcodeZone' => $postcodeZone,
            'districts' => $districts
        ]);
    }
}

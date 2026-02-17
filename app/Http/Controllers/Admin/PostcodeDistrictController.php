<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\DatabaseService;
use App\Models\PostDistrict;

class PostcodeDistrictController extends Controller
{

    protected $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    public function index(Request $request)
    {
        $params = [];
        $params['sort_by'] = $request->get('sort_by', 'id');
        $params['sort_order'] = $request->get('sort_order', 'desc');

        if (null != $request->get('search')) {
            $params['like'] = [
                'postcode_area' => $request->get('search'),
                'district_name' => $request->get('search'),
            ];
        }

        $districts = $this->databaseService->getByParams(PostDistrict::class, $params);

        return view('admin.modules.postcode_district.index', [
            'districts' => $districts,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }
}

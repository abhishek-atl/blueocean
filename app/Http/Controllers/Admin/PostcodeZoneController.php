<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\DatabaseService;

use App\Models\PostcodeZone;
use App\Models\PostDistrict;

class PostcodeZoneController  extends Controller
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

        $zones = $this->databaseService->getByParams(PostcodeZone::class, $params);

        return view('admin.modules.postcode_zone.index', ['zones' => $zones]);
    }

    public function createEdit($id)
    {
        $postcodeZone = null;
        if ($id) {
            $postcodeZone = $this->databaseService->find(PostcodeZone::class, $id);
            $postcodeZone->load(['postcodes']);
        }

        $districts = $this->databaseService->getByParams(PostDistrict::class, ['with' => 'postcodes', 'all' => true]);

        return view('admin.modules.postcode_zone.create_edit', [
            'postcodeZone' => $postcodeZone,
            'districts' => $districts
        ]);
    }

    public function store(Request $request)
    {
        $postcodeZone = $this->databaseService->save(PostcodeZone::class, $request->all());
        $postcodeZone->postcodes()->sync($request->postcode);
        return redirect()
            ->route('admin.postcode_zones.index')
            ->with('status', 'Postcode zone saved successfully');
    }
}

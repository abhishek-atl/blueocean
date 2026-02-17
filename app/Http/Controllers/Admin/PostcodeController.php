<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\DatabaseService;
use App\Models\Postcode;
use App\Models\PostDistrict;

class PostcodeController extends Controller
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
        $params['with'] = ['district'];

        if (null != $request->get('search')) {
            $params['like'] = [
                'postcode' => $request->get('search'),
            ];
        }

        $postcodes = $this->databaseService->getByParams(Postcode::class, $params);

        return view('admin.modules.postcode.index', [
            'postcodes' => $postcodes,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $postcode = null;
        if ($id) {
            $postcode = $this->databaseService->getByParams(Postcode::class, ['id' => $id]);
        }
        $districts = $this->databaseService->getByParams(PostDistrict::class, ['all' => true]);

        return view('admin.modules.postcode.postcode_add_edit', [
            'districts' => $districts,
            'postcode' => $postcode,
        ]);
    }

    public function store(Request $request)
    {
        $postcode = $this->databaseService->save(Postcode::class, $request->all());
        return redirect()
            ->route('admin.postcodes.edit', ['id' => $postcode->id])
            ->with('status', 'Postcode saved successfully');
    }

    public function destroy($id)
    {
        $this->databaseService->destroy(Postcode::class, $id);
        return redirect()
            ->route('admin.postcodes.index')
            ->with('status', 'Postcode deleted successfully');
    }
}

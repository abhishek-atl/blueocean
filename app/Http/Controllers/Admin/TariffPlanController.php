<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TariffPlan;
use App\Services\DatabaseService;

class TariffPlanController extends Controller
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
                'name' => $request->get('search'),
            ];
        }

        $tariffPlans = $this->databaseService->getByParams(TariffPlan::class, $params);

        return view('admin.modules.tariff_plan.index', [
            'tariffPlans' => $tariffPlans,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $tariffPlan = null;
        if ($id) {
            $tariffPlan = $this->databaseService->find(TariffPlan::class, $id);
        }

        return view('admin.modules.tariff_plan.create_edit', [
            'tariffPlan' => $tariffPlan,
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->except('_token');

        if (isset($params['id'])) {
            $tariffPlan = $this->databaseService->find(TariffPlan::class, $params['id']);
            $tariffPlan->update($params);
            $message = 'Tariff Plan updated successfully.';
        } else {
            $tariffPlan = TariffPlan::create($params);
            $message = 'Tariff Plan created successfully.';
        }

        return redirect()
            ->route('admin.tariff_plans.edit', ['id' => $tariffPlan->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        $this->databaseService->destroy(TariffPlan::class, $id);
        return redirect()
            ->route('admin.tariff_plans.index')
            ->with('status', 'Tariff Plan deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promocode;
use App\Models\TariffPlan;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PromocodeController extends Controller
{
    public function index(Request $request): View
    {
        $sortBy = in_array($request->get('sort_by'), ['id', 'code', 'amount', 'active', 'expires_at'], true)
            ? $request->get('sort_by')
            : 'id';
        $sortOrder = $request->get('sort_order') === 'asc' ? 'asc' : 'desc';

        $promocodes = Promocode::query()
            ->with('tariffPlans')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('code', 'like', '%' . $request->get('search') . '%');
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(config('custom.db.per_page'))
            ->withQueryString();

        return view('admin.modules.promocode.index', [
            'promocodes' => $promocodes,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
        ]);
    }

    public function createEdit($id = null): View
    {
        $promocode = $id ? Promocode::with('tariffPlans')->findOrFail($id) : null;

        return view('admin.modules.promocode.create_edit', [
            'promocode' => $promocode,
            'tariffPlans' => TariffPlan::query()->orderBy('duration')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (is_string($request->input('code'))) {
            $request->merge([
                'code' => strtoupper(trim($request->input('code'))),
            ]);
        }

        $validated = $request->validate([
            'id' => ['nullable', 'integer', 'exists:promocodes,id'],
            'code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('promocodes', 'code')->ignore($request->input('id')),
            ],
            'amount' => ['required', 'numeric', 'min:0'],
            'active' => ['required', 'boolean'],
            'expires_at' => ['required', Rule::date()->format('d/m/Y H:i')],
            'tariff_plan_ids' => ['required', 'array', 'min:1'],
            'tariff_plan_ids.*' => ['integer', 'distinct', 'exists:tariff_plans,id'],
        ]);

        $promocode = DB::transaction(function () use ($validated) {
            $tariffPlanIds = $validated['tariff_plan_ids'];
            unset($validated['tariff_plan_ids']);

            $promocode = isset($validated['id'])
                ? Promocode::findOrFail($validated['id'])
                : new Promocode;

            unset($validated['id']);
            $validated['expires_at'] = Carbon::createFromFormat(config('custom.format.date_time'), $validated['expires_at']);
            $promocode->fill($validated)->save();
            $promocode->tariffPlans()->sync($tariffPlanIds);

            return $promocode;
        });

        return redirect()
            ->route('admin.promocodes.edit', ['id' => $promocode->id])
            ->with('status', 'Promocode saved successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        DB::transaction(function () use ($id) {
            $promocode = Promocode::findOrFail($id);
            $promocode->tariffPlans()->detach();
            $promocode->delete();
        });

        return redirect()
            ->route('admin.promocodes.index')
            ->with('status', 'Promocode deleted successfully.');
    }
}

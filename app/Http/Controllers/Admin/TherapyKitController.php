<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTherapyKitRequest;
use App\Models\TherapyKit;
use Illuminate\Http\Request;

class TherapyKitController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = in_array($request->input('sort_by'), ['id', 'name', 'price', 'type', 'active'], true)
            ? $request->input('sort_by')
            : 'id';
        $sortOrder = $request->input('sort_order') === 'asc' ? 'asc' : 'desc';

        $therapyKits = TherapyKit::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->input('search').'%');
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(config('custom.db.per_page'))
            ->withQueryString();

        return view('admin.modules.therapy_kit.index', [
            'therapyKits' => $therapyKits,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
        ]);
    }

    public function createEdit(?int $id = null)
    {
        return view('admin.modules.therapy_kit.create_edit', [
            'therapyKit' => $id ? TherapyKit::query()->findOrFail($id) : null,
        ]);
    }

    public function store(StoreTherapyKitRequest $request)
    {
        $attributes = $request->validated();
        $id = $attributes['id'] ?? null;
        unset($attributes['id']);

        if ($id) {
            $therapyKit = TherapyKit::query()->findOrFail($id);
            $therapyKit->update($attributes);
            $message = 'Therapy kit updated successfully.';
        } else {
            $therapyKit = TherapyKit::query()->create($attributes);
            $message = 'Therapy kit added successfully.';
        }

        return redirect()
            ->route('admin.therapy_kits.edit', ['id' => $therapyKit->id])
            ->with('status', $message);
    }

    public function destroy(int $id)
    {
        $therapyKit = TherapyKit::query()->findOrFail($id);
        $therapyKit->therapists()->detach();
        $therapyKit->delete();

        return redirect()
            ->back()
            ->with('status', 'Therapy kit deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTreatmentRequest;
use App\Models\Treatment;
use App\Models\TreatmentCategory;
use App\Repositories\UploadRepository;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    protected $uploadRepository;

    public function __construct(UploadRepository $uploadRepository)
    {
        $this->uploadRepository = $uploadRepository;
    }

    public function index()
    {
        $treatments = Treatment::with('categories')->paginate(15);
        return view('admin.modules.treatment.index', ['treatments' => $treatments]);
    }

    public function addEdit($id = null)
    {
        $isEdit = false;
        if ($id) {
            $treatment = Treatment::findOrFail($id);
            $treatment->load('categories');
            $treatmentCategoryIds = $treatment->categories->pluck('id')->toArray();
            $isEdit = true;
        }

        $categories = TreatmentCategory::all();
        return view('admin.modules.treatment.addUpdate', [
            'treatment' => $treatment ?? null,
            'categories' => $categories,
            'isEdit' => $isEdit,
            'treatmentCategoryIds' => $treatmentCategoryIds ?? [],
        ]);
    }

    public function store(StoreTreatmentRequest $request)
    {
        $params = $request->except('_token', 'image');

        if ($request->has('image')) {
            $file = $request->file('image');
            $uploadPath = config('custom.upload.treatment_path');
            $path = $this->uploadRepository->upload($file, $uploadPath);
            $params['image'] =  $path;
        }

        if (isset($params['id'])) {
            $treatment = Treatment::findOrFail($params['id']);
            $treatment->update($params);
            $message = 'Treatment updated successfully.';
        } else {
            $treatment = Treatment::create($params);
            $message = 'Treatment added successfully.';
        }

        $treatment->categories()->sync($request->input('treatment_category_id', []));

        return redirect()
            ->route('admin.treatments.edit', ['id' => $treatment->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        $treatment = Treatment::findOrFail($id);
        $treatment->categories()->detach();
        $treatment->delete();

        return redirect()
            ->back()
            ->with('status', 'Treatment deleted successfully.');
    }

    public function toggleActive(Treatment $treatment)
    {
        $treatment->update(['is_active' => !$treatment->is_active]);

        return redirect()
            ->route('treatments.index')
            ->with('success', 'Treatment status updated successfully.');
    }
}

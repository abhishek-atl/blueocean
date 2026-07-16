<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTreatmentCategoryRequest;
use Illuminate\Http\Request;

use App\Models\Treatment;
use App\Models\TreatmentCategory;

use App\Services\DatabaseService;
use App\Services\UploadService;

use Illuminate\Support\Str;

class TreatmentCategoryController extends Controller
{
    protected UploadService $uploadService;
    protected  DatabaseService $databaseService;

    public function __construct(
        UploadService $uploadService,
        DatabaseService $databaseService
    ) {
        $this->uploadService = $uploadService;
        $this->databaseService = $databaseService;
    }

    public function index(Request $request)
    {
        $params = [];
        $params['sort_by'] = $request->input('sort_by', 'id');
        $params['sort_order'] = $request->input('sort_order', 'desc');

        if (null != $request->input('search')) {
            $params['like'] = ['name' => $request->input('search')];
        }

        $treatmentCategories = $this->databaseService->getByParams(TreatmentCategory::class, $params);

        return view('admin.modules.treatment_category.index', [
            'treatmentCategories' => $treatmentCategories,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $treatmentCategory = null;
        if ($id) {
            $treatmentCategory = $this->databaseService->find(TreatmentCategory::class, $id);
        }
        return view('admin.modules.treatment_category.create_edit', [
            'treatmentCategory' => $treatmentCategory,
        ]);
    }

    public function store(StoreTreatmentCategoryRequest $request)
    {
        $params = $request->except('_token', 'image');

        $params['slug'] = Str::of($request->name)->slug('-');

        if ($request->has('image')) {
            $file = $request->file('image');
            $uploadPath = config('custom.upload.treatment_category_path');
            $path = $this->uploadService->upload($file, $uploadPath);
            $params['image'] =  $path;
        }

        if (isset($params['id'])) {
            $treatmentCategory = $this->databaseService->find(TreatmentCategory::class, $params['id']);
            $treatmentCategory->update($params);
            $message = 'Treatment category updated successfully.';
        } else {
            $treatmentCategory = TreatmentCategory::create($params);
            $message = 'Treatment category added successfully.';
        }

        return redirect()
            ->route('admin.treatment_categories.edit', ['id' => $treatmentCategory->id])
            ->with('status', $message);
    }
    
    public function destroy($id)
    {
        $treatmentCategory = $this->databaseService->find(TreatmentCategory::class, $id);
        $treatmentCategory->categories()->detach();
        $treatmentCategory->delete();

        return redirect()
            ->back()
            ->with('status', 'Treatment category deleted successfully.');
    }
}

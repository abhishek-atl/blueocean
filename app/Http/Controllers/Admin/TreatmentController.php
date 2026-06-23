<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTreatmentRequest;
use Illuminate\Http\Request;

use App\Models\Treatment;
use App\Models\TreatmentCategory;

use App\Services\DatabaseService;
use App\Services\UploadService;

use Illuminate\Support\Str;

class TreatmentController extends Controller
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
        $params['sort_by'] = $request->get('sort_by', 'id');
        $params['sort_order'] = $request->get('sort_order', 'desc');

        $params['with'] = ['categories'];

        if (null != $request->get('search')) {
            $params['like'] = ['name' => $request->get('search')];
        }

        $treatments = $this->databaseService->getByParams(Treatment::class, $params);

        return view('admin.modules.treatment.index', [
            'treatments' => $treatments,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $treatment = null;
        if ($id) {
            $treatment = $this->databaseService->find(Treatment::class, $id);
            $treatment->load('categories');
            $treatmentCategoryIds = $treatment->categories->pluck('id')->toArray();
        }

        $categories = $this->databaseService->getByParams(TreatmentCategory::class, ['all' => true]);
        return view('admin.modules.treatment.create_edit', [
            'treatment' => $treatment,
            'categories' => $categories,
            'treatmentCategoryIds' => $treatmentCategoryIds ?? [],
        ]);
    }

    public function store(StoreTreatmentRequest $request)
    {
        $params = $request->except('_token', 'image');

        $params['slug'] = Str::of($request->name)->slug('-');

        if ($request->has('image')) {
            $file = $request->file('image');
            $uploadPath = config('custom.upload.treatment_path');
            $path = $this->uploadService->upload($file, $uploadPath);
            $params['image'] =  $path;
        }

        if (isset($params['id'])) {
            $treatment = $this->databaseService->find(Treatment::class, $params['id']);
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
        $treatment = $this->databaseService->find(Treatment::class, $id);
        $treatment->categories()->detach();
        $treatment->delete();

        return redirect()
            ->back()
            ->with('status', 'Treatment deleted successfully.');
    }
}

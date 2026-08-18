<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Models\Page;
use App\Services\DatabaseService;
use App\Services\UploadService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected DatabaseService $databaseService;

    protected UploadService $uploadService;

    public function __construct(
        DatabaseService $databaseService,
        UploadService $uploadService,
    ) {
        $this->databaseService = $databaseService;
        $this->uploadService = $uploadService;
        abort_if(! auth()->user()->can('Content Management'), 403);
    }

    public function index(Request $request)
    {
        $sortBy = in_array($request->get('sort_by'), ['id', 'title', 'slug', 'author', 'active'], true)
            ? $request->get('sort_by')
            : 'id';
        $sortOrder = $request->get('sort_order') === 'asc' ? 'asc' : 'desc';

        $params = [
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
        ];

        if ($request->filled('search')) {
            $params['like'] = [
                'title' => $request->get('search'),
                'slug' => $request->get('search'),
            ];
        }

        return view('admin.modules.page.index', [
            'pages' => $this->databaseService->getByParams(Page::class, $params),
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
        ]);
    }

    public function createEdit($id = null)
    {
        return view('admin.modules.page.create_edit', [
            'page' => $id ? Page::query()->findOrFail($id) : null,
        ]);
    }

    public function store(StorePageRequest $request)
    {
        $params = $request->validated();
        $id = $params['id'] ?? null;
        unset($params['id'], $params['image']);

        if ($request->hasFile('image')) {
            $params['image'] = $this->uploadService->upload(
                $request->file('image'),
                config('custom.upload.page_path')
            );
        }

        if ($id) {
            $page = Page::query()->findOrFail($id);
            $page->update($params);
            $message = 'Page updated successfully.';
        } else {
            $page = Page::query()->create($params);
            $message = 'Page created successfully.';
        }

        return redirect()
            ->route('admin.pages.edit', ['id' => $page->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        Page::query()->findOrFail($id)->delete();

        return redirect()
            ->route('admin.pages.index')
            ->with('status', 'Page deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostTag;
use App\Services\DatabaseService;
use Illuminate\Support\Str;

class PostTagController extends Controller
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
                'slug' => $request->get('search'),
            ];
        }

        $tags = $this->databaseService->getByParams(PostTag::class, $params);

        return view('admin.modules.post_tag.index', [
            'tags' => $tags,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $tag = null;
        if ($id) {
            $tag = $this->databaseService->find(PostTag::class, $id);
        }

        return view('admin.modules.post_tag.create_edit', [
            'tag' => $tag,
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->except('_token');

        // Auto-generate slug if not provided
        if (empty($params['slug'])) {
            $params['slug'] = Str::slug($params['name']);
        }

        if (isset($params['id'])) {
            $tag = $this->databaseService->find(PostTag::class, $params['id']);
            $tag->update($params);
            $message = 'Tag updated successfully.';
        } else {
            $tag = PostTag::create($params);
            $message = 'Tag created successfully.';
        }

        return redirect()
            ->route('admin.post_tags.edit', ['id' => $tag->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        $tag = $this->databaseService->find(PostTag::class, $id);
        if ($tag) {
            $tag->posts()->detach();
            $tag->delete();
        }

        return redirect()
            ->route('admin.post_tags.index')
            ->with('status', 'Tag deleted successfully');
    }
}

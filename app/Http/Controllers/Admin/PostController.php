<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostTag;
use App\Services\DatabaseService;
use App\Services\UploadService;

class PostController extends Controller
{
    protected $databaseService;
    protected $uploadService;

    public function __construct(DatabaseService $databaseService, UploadService $uploadService)
    {
        $this->databaseService = $databaseService;
        $this->uploadService = $uploadService;
        abort_if(!auth()->user()->can('Content Management'), 403);
    }

    public function index(Request $request)
    {
        $params = [];
        $params['sort_by'] = $request->get('sort_by', 'id');
        $params['sort_order'] = $request->get('sort_order', 'desc');
        $params['with'] = ['tags'];

        if (null != $request->get('search')) {
            $params['like'] = [
                'title' => $request->get('search'),
                'slug' => $request->get('search'),
            ];
        }

        $posts = $this->databaseService->getByParams(Post::class, $params);

        return view('admin.modules.post.index', [
            'posts' => $posts,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $post = null;
        $postTagIds = [];

        if ($id) {
            $post = $this->databaseService->find(Post::class, $id);
            if ($post) {
                $post->load('tags');
                $postTagIds = $post->tags->pluck('id')->toArray();
            }
        }

        $tags = $this->databaseService->getByParams(PostTag::class, ['all' => true]);

        return view('admin.modules.post.create_edit', [
            'post' => $post,
            'tags' => $tags,
            'postTagIds' => $postTagIds,
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->except('_token', 'image', 'post_tag_id');

        if ($request->has('image')) {
            $file = $request->file('image');
            $uploadPath = config('custom.upload.post_path', 'uploads/posts');
            $path = $this->uploadService->upload($file, $uploadPath);
            $params['image'] = $path;
        }

        if (isset($params['id'])) {
            $post = $this->databaseService->find(Post::class, $params['id']);
            $post->update($params);
            $message = 'Post updated successfully.';
        } else {
            $post = Post::create($params);
            $message = 'Post created successfully.';
        }

        $post->tags()->sync($request->input('post_tag_id', []));

        return redirect()
            ->route('admin.posts.edit', ['id' => $post->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        $post = $this->databaseService->find(Post::class, $id);
        if ($post) {
            $post->tags()->detach();
            $post->comments()->delete();
            $post->delete();
        }

        return redirect()
            ->route('admin.posts.index')
            ->with('status', 'Post deleted successfully');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostComment;
use App\Models\Post;
use App\Services\DatabaseService;

class PostCommentController extends Controller
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
        $params['with'] = ['post'];

        if (null != $request->get('search')) {
            $params['like'] = [
                'author' => $request->get('search'),
                'email' => $request->get('search'),
            ];
        }

        $comments = $this->databaseService->getByParams(PostComment::class, $params);

        return view('admin.modules.post_comment.index', [
            'comments' => $comments,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $comment = null;
        if ($id) {
            $comment = $this->databaseService->find(PostComment::class, $id);
            if ($comment) {
                $comment->load('post');
            }
        }

        $posts = $this->databaseService->getByParams(Post::class, ['all' => true]);

        return view('admin.modules.post_comment.create_edit', [
            'comment' => $comment,
            'posts' => $posts,
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->except('_token');

        if (isset($params['id'])) {
            $comment = $this->databaseService->find(PostComment::class, $params['id']);
            $comment->update($params);
            $message = 'Comment updated successfully.';
        } else {
            $comment = PostComment::create($params);
            $message = 'Comment created successfully.';
        }

        return redirect()
            ->route('admin.post_comments.edit', ['id' => $comment->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        $this->databaseService->destroy(PostComment::class, $id);
        return redirect()
            ->route('admin.post_comments.index')
            ->with('status', 'Comment deleted successfully');
    }
}

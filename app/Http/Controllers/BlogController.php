<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostTag;
use App\Services\DatabaseService;
use Illuminate\Support\Facades\View;

class BlogController extends Controller
{

    protected DatabaseService $databaseService;


    public function __construct(
        DatabaseService $databaseService,

    ) {
        $this->databaseService = $databaseService;
    }

    public function index($tag = null)
    {
        $params = [];
        $params['where'] = ['active' => true];

        if (request('search')) {
            $search = '%' . request('search') . '%';
            $params['like'] = ['title' => $search];
        }
        $params['order_by'] = request('order_by') ? request('order_by') : 'updated_at';
        $params['order'] = request('order') ? request('order') : 'desc';
        $params['per_page'] = 15;
        $params['with'] = ['tags'];
        if ($tag) {
            $params['ofType'] = ['tag' => $tag];
        }
        $posts =  $this->databaseService->getByParams(Post::class, $params);
        $tags = $this->databaseService->getByParams(PostTag::class, ['order_by' => 'name', 'order' => 'asc']);

        $seoMeta = '';
        if ($tag != 'all') {
            $seoMeta = $tags->where('name', $tag)->first();
        }
        return view('frontend.modules.blog.index', [
            'posts' => $posts,
            'tags' => $tags,
            'currentTag' => $tag ? $tag : 'all',
            'seoMeta' => $seoMeta
        ]);
    }

    public function blog_detail($slug)
    {
        $post = $this->databaseService->getByParams(Post::class, ['where' => ['slug' => $slug]])->first();
        if (!$post) {
            abort(404);
        }
        $post->load(['tags']);

        $qb = Post::whereRaw('1=1');
        $qb->whereActive(true);
        $qb->limit(3);
        $qb->where('id', '!=', $post->id);
        $relatedPosts =  $qb->get();

        $bookingBlockHtml = View::make('frontend.modules.booking.partials.booking_block')->render();

        return view('frontend.modules.blog.detail', [
            'post' => $post,
            'posts' => $relatedPosts,
            'bookingBlockHtml' => $bookingBlockHtml
        ]);
    }
}

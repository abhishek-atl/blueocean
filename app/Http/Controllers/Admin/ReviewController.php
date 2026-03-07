<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Services\DatabaseService;
use App\Services\UploadService;

class ReviewController extends Controller
{
    protected $databaseService;
    protected $uploadService;

    public function __construct(DatabaseService $databaseService, UploadService $uploadService)
    {
        $this->databaseService = $databaseService;
        $this->uploadService = $uploadService;
    }

    public function index(Request $request)
    {
        $params = [];
        $params['sort_by'] = $request->get('sort_by', 'id');
        $params['sort_order'] = $request->get('sort_order', 'desc');

        if (null != $request->get('search')) {
            $params['like'] = [
                'first_name' => $request->get('search'),
                'last_name' => $request->get('search'),
                'email' => $request->get('search'),
            ];
        }

        $reviews = $this->databaseService->getByParams(Review::class, $params);

        return view('admin.modules.review.index', [
            'reviews' => $reviews,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $review = null;
        if ($id) {
            $review = $this->databaseService->find(Review::class, $id);
        }

        return view('admin.modules.review.create_edit', [
            'review' => $review,
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->except('_token', 'photo');

        if ($request->has('photo')) {
            $file = $request->file('photo');
            $uploadPath = config('custom.upload.review_path', 'uploads/reviews');
            $path = $this->uploadService->upload($file, $uploadPath);
            $params['photo'] = $path;
        }

        if (isset($params['id'])) {
            $review = $this->databaseService->find(Review::class, $params['id']);
            $review->update($params);
            $message = 'Review updated successfully.';
        } else {
            $review = Review::create($params);
            $message = 'Review created successfully.';
        }

        return redirect()
            ->route('admin.reviews.edit', ['id' => $review->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        $this->databaseService->destroy(Review::class, $id);
        return redirect()
            ->route('admin.reviews.index')
            ->with('status', 'Review deleted successfully');
    }
}

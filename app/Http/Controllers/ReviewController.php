<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use App\Services\DatabaseService;
use App\Services\MailService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    protected DatabaseService $databaseService;
    protected MailService $mailService;

    public function __construct(
        DatabaseService $databaseService,
        MailService $mailService
    ) {
        $this->databaseService = $databaseService;
        $this->mailService = $mailService;
    }

    public function index()
    {
        $reviews = $this->databaseService->getByParams(Review::class, [
            'where' => ['active' => 1],
            'order_by' => 'created_at',
            'order' => 'desc',
            'per_page' => config('custom.db.per_page'),
        ]);

        $evaluationTotal = Review::where('active', 1)->whereNotNull('evaluation')->sum('evaluation');
        $totalReviews = Review::where('active', 1)->whereNotNull('evaluation')->count();
        $averageRating = $totalReviews > 0 ? round($evaluationTotal / $totalReviews, 1) : 0;

        return view('frontend.modules.reviews.index', [
            'reviews' => $reviews,
            'evaluationTotal' => $evaluationTotal,
            'totalReviews' => $totalReviews,
            'averageRating' => $averageRating
        ]);
    }

    public function addReview(Request $request)
    {
        $evaluationTotal = Review::where('active', 1)->whereNotNull('evaluation')->sum('evaluation');
        $totalReviews = Review::where('active', 1)->whereNotNull('evaluation')->count();
        $averageRating = $totalReviews > 0 ? round($evaluationTotal / $totalReviews, 1) : 0;

        return view('frontend.modules.reviews.add', [
            'evaluationTotal' => $evaluationTotal,
            'totalReviews' => $totalReviews,
            'averageRating' => $averageRating
        ]);
    }

    public function addReviewPost(StoreReviewRequest $request)
    {
        $params = $request->all();
        $params['ip_address'] = $request->getClientIp();
        $review = $this->databaseService->save(Review::class, $params);
        $this->mailService->sendReviewMail($review);
        return redirect(route('reviews'))->with('success', 'Your feedback will be reviewed by our moderators and then published');
    }
}

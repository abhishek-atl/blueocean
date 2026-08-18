<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTherapistApplication;
use App\Models\Banner;
use App\Models\FAQ;
use App\Models\TherapistApplication;
use App\Models\TherapistReview;
use App\Models\TherapyKit;
use Illuminate\Http\Request;

use App\Models\Treatment;
use App\Models\TreatmentCategory;
use App\Models\User;
use App\Services\MailService;
use App\Services\SmsService;
use App\Services\UploadService;

class HomeController extends Controller
{
    protected MailService $mailService;
    protected UploadService $uploadService;
    protected SmsService $smsService;

    public function __construct(
        MailService $mailService,
        UploadService $uploadService,
        SmsService $smsService,
    ) {
        $this->mailService = $mailService;
        $this->uploadService = $uploadService;
        $this->smsService = $smsService;
    }

    public function home(Request $request)
    {
        $treatmentCategories = TreatmentCategory::query()
            ->where('active', true)
            ->orderBy('id', 'asc')
            ->limit(3)
            ->get();

        $therapists = User::query()
            ->where('user_type', User::TYPE_THERAPIST)
            ->where('active', true)
            ->whereHas('therapist_profile', function ($query) {
                $query->where('on_therapist_page', true);
            })
            ->with(['user_profile', 'therapist_profile', 'treatments'])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $banner = Banner::where('placement', 'home')
            ->where('active', true)->first();

        $faqs = FAQ::where('active', true)
            ->orderBy('display_order')
            ->get();

        $review = TherapistReview::where('active', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $evaluationTotal = TherapistReview::where('active', 1)->whereNotNull('avg_evaluation')->sum('avg_evaluation');
        $totalReviews = TherapistReview::where('active', 1)->whereNotNull('avg_evaluation')->count();
        $averageRating = $totalReviews > 0 ? round($evaluationTotal / $totalReviews, 1) : 0;

        return view('frontend.modules.home.index', [
            'treatmentCategories' => $treatmentCategories,
            'therapists' => $therapists,
            'banner' => $banner,
            'faqs' => $faqs,
            'reviews' => $review,
            'totalReviews' => $totalReviews,
            'averageRating' => $averageRating
        ]);
    }

    public function treatments(Request $request)
    {
        $currentTag = 'all';
        if ($request->input('category')) {
            $currentTag = $request->input('category');
        }

        $query = Treatment::query()->where('active', true);
        if ($currentTag !== 'all') {
            $query->whereHas('categories', function ($query) use ($currentTag) {
                $query->where('slug', $currentTag);
            });
        }
        $treatments = $query->where('on_treatment_page', true)
            ->orderBy('name')
            ->get();

        $categories = TreatmentCategory::query()
            ->orderBy('id', 'asc')
            ->get();

        return view('frontend.modules.treatments.index', [
            'treatments' => $treatments,
            'categories' => $categories,
            'currentTag' => $currentTag
        ]);
    }

    public function treatmentDetail(string $slug)
    {
        $treatment = Treatment::query()
            ->where('active', true)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.modules.treatments.detail', [
            'treatment' => $treatment
        ]);
    }

    public function therapists()
    {
        $therapists = User::query()
            ->where('user_type', User::TYPE_THERAPIST)
            ->where('active', true)
            ->whereHas('therapist_profile', function ($query) {
                $query->where('on_therapist_page', true);
            })
            ->with(['user_profile', 'therapist_profile'])
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        return view('frontend.modules.therapists.index', [
            'therapists' => $therapists,
        ]);
    }

    public function therapistDetail(string $slug)
    {
        $therapist = User::query()
            ->where('user_type', User::TYPE_THERAPIST)
            ->where('active', true)
            ->whereHas('therapist_profile', function ($query) use ($slug) {
                $query->where('on_therapist_page', true)
                    ->where('slug', $slug);
            })
            ->with(['user_profile', 'therapist_profile', 'treatments' => function ($query) {
                $query->where('active', true)->orderBy('name');
            }])
            ->firstOrFail();

        return view('frontend.modules.therapists.detail', [
            'therapist' => $therapist,
        ]);
    }

    public function joinUs(Request $request)
    {
        $therapyKits = TherapyKit::query()
            ->where('active', true)
            ->orderBy('type')
            ->orderBy('name')
            ->get();

        return view('frontend.modules.therapists.join_us', [
            'therapyKits' => $therapyKits,
        ]);
    }

    public function joinUsPost(StoreTherapistApplication $request)
    {

        $application = new TherapistApplication();
        $application->first_name = $request->input('first_name');
        $application->last_name = $request->input('last_name');
        $application->email = $request->input('email');
        $application->mobile = $request->input('mobile');
        $application->therapy_kit_ids = array_map('intval', $request->validated('therapy_kits', []));
        $application->ip_address = $request->ip();
        $application->user_agent = $request->userAgent();
        $application->save();

        $params = $request->only(['first_name', 'last_name', 'email', 'mobile']);
        $params['therapy_kits'] = TherapyKit::query()
            ->whereIn('id', $application->therapy_kit_ids ?? [])
            ->orderBy('type')
            ->orderBy('name')
            ->pluck('name')
            ->all();
        $params['ip'] = $request->ip();
        $params['user_agent'] = $request->userAgent();

        $this->mailService->sendTherapistApplicationMail($params);

        $this->smsService->sendSms('New Therapist application has been recieved');

        return redirect()
            ->route('join_us')
            ->with('success', 'Thank you! <br />We have received your application form. <br />If you are successful, we will be in touch very soon!');
    }

    public function faq()
    {
        $faqs = FAQ::where('active', true)
            ->orderBy('display_order')
            ->get();

        return view('frontend.modules.faq.index', [
            'faqs' => $faqs
        ]);
    }
}

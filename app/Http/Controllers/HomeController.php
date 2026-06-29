<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTherapistApplication;
use App\Models\Banner;
use App\Models\FAQ;
use Illuminate\Http\Request;

use App\Models\Treatment;
use App\Models\TreatmentCategory;
use App\Models\User;
use App\Services\MailService;
use App\Services\UploadService;

class HomeController extends Controller
{
    protected MailService $mailService;
    protected UploadService $uploadService;

    public function __construct(
        MailService $mailService,
        UploadService $uploadService,
    ) {
        $this->mailService = $mailService;
        $this->uploadService = $uploadService;
    }

    public function home(Request $request)
    {
        $treatments = Treatment::query()
            ->where('active', true)
            ->orderBy('name')
            ->limit(6)
            ->get();

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

        $banner = Banner::where('placement', 'home')
            ->where('active', true)->first();

        $faqs = FAQ::where('active', true)
            ->orderBy('display_order')
            ->get();

        return view('frontend.modules.home.index', [
            'treatments' => $treatments,
            'therapists' => $therapists,
            'banner' => $banner,
            'faqs' => $faqs
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
            ->orderBy('name')
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
        return view('frontend.modules.therapists.join_us');
    }

    public function joinUsPost(StoreTherapistApplication $request)
    {
        $params = $request->safe()->except(['cv', 'photo']);
        $uploadPath = config('custom.upload.job_application_path');

        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $path = $this->uploadService->upload($file, $uploadPath);
            $params['cv'] = public_path('uploads/' . $uploadPath . '/' . $path);
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $this->uploadService->upload($file, $uploadPath);
            $params['photo'] = public_path('uploads/' . $uploadPath . '/' . $path);
        }

        $params['ip'] = $request->ip();
        $params['user_agent'] = $request->userAgent();

        $this->mailService->sendTherapistApplicationMail($params);

        return redirect()
            ->route('join_us')
            ->with('success', 'Thank you! <br />We have received your application form. <br />If you are successful, we will be in touch very soon!');
    }
}

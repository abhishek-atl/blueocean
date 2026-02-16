<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostcodeZone;
use App\Models\PostDistrict;
use App\Models\TherapistHoliday;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Services\BookingService;
use App\Services\UploadService;
use App\Services\UserService;

class TherapistController extends Controller
{
    protected $uploadService;
    protected $bookingService;
    protected $userService;

    public function __construct(
        UploadService $uploadService,
        BookingService $bookingService,
        UserService $userService
    ) {
        $this->uploadService = $uploadService;
        $this->bookingService = $bookingService;
        $this->userService = $userService;
    }

    public function index()
    {
        $therapists = User::role('Therapist')
            ->with('user_profile')
            ->paginate(15);
        return view('admin.modules.therapist.index', ['therapists' => $therapists]);
    }

    public function addEdit($id = null)
    {
        $isEdit = false;
        if ($id) {
            $user = User::findOrFail($id);
            $user->load(['user_profile', 'therapist_profile']);
            $isEdit = true;
        }

        return view('admin.modules.therapist.addUpdate', [
            'user' => $user ?? null,
            'isEdit' => $isEdit,
        ]);
    }

    public function store(Request $request)
    {
        $params = $request->except(['_token', 'image']);

        $user = $this->userService->save($params);
        $this->userService->saveUserProfile($user, $params);

        if ($request->has('image')) {
            $file = $request->file('image');
            $uploadPath = config('custom.upload.user_path');
            $path = $this->uploadService->upload($file, $uploadPath);
            $this->userService->saveUserImage($user, $path);
        }
        $user->assignRole('Therapist');

        if (isset($params['id'])) {
            $message = 'Therapist updated successfully.';
        } else {
            $message = 'Therapist added successfully.';
        }

        return redirect()
            ->route('admin.therapists.edit', ['id' => $user->id])
            ->with('status', $message);
    }

    public function destroy($id)
    {
        $therapist = User::findOrFail($id);
        $therapist->delete();

        return redirect()
            ->back()
            ->with('status', 'Therapist deleted successfully.');
    }

    public function therapistProfile($id)
    {
        $isEdit = false;
        if ($id) {
            $user = User::findOrFail($id);
            $user->load(['user_profile', 'therapist_profile']);
            $isEdit = true;
        }

        return view('admin.modules.therapist.profile', [
            'user' => $user ?? null,
            'isEdit' => $isEdit,
        ]);
    }

    public function therapistProfileStore(Request $request)
    {
        $params = $request->except(['_token', 'image']);

        $user = $this->userService->get($params['id']);
        $this->userService->saveTherapistProfile($user, $params);

        return redirect()
            ->back()
            ->with('status', 'Therapist updated successfully.');
    }

    public function treatments($id)
    {
        $isEdit = true;
        $user = User::find($id);
        $user->load(['treatments', 'user_profile']);

        $treatments = Treatment::all();
        return view('admin.modules.therapist.treatments', [
            'isEdit' => $isEdit,
            'treatments' => $treatments,
            'user' => $user
        ]);
    }

    public function treatmentsStore(Request $request)
    {
        $therapist = $this->userService->get(request('id'));
        $therapist->treatments()->sync($request->treatments);
        return redirect()->back()->with('status', 'Treatments updated successfully');
    }

    public function postcodes($id)
    {
        $isEdit = true;
        $user = User::find($id);;
        $user->load('postcodes');

        $districts = PostDistrict::all();
        $zones = PostcodeZone::all();

        return view('admin.modules.therapist.postcodes', [
            'isEdit' => $isEdit,
            'districts' => $districts,
            'user' => $user,
            'zones' => $zones
        ]);
    }

    public function postcodesStore(Request $request)
    {
        $therapist = $this->userService->get(request('id'));
        $therapist->postcodes()->sync($request->postcodes);
        return redirect()->back()->with('status', 'Postcodes updated successfully');
    }

    public function schedules($id)
    {

        $isEdit = true;
        $user = User::find($id);
        $timeSlots = $this->bookingService->getTime();
        $days =
            [
                'mon' => 'Monday',
                'tue' => 'Tuesday',
                'wed' => 'Wednesday',
                'thu' => 'Thursdays',
                'fri' => 'Friday',
                'sat' => 'Saturday',
                'sun' => 'Sunday'
            ];

        return view('admin.modules.therapist.schedules', [
            'isEdit' => $isEdit,
            'user' => $user,
            'timeSlots' => $timeSlots,
            'days' => $days
        ]);
    }

    public function schedulesStore(Request $request)
    {
        $user = $this->userService->get(request('id'));
        $days = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
        $daysSchedule = $request->only($days);
        foreach ($days as $day) {
            $newSchedules[$day] = isset($daysSchedule[$day]) ? implode(',', $daysSchedule[$day]) : null;
        }
        $this->userService->saveSchedule($user, $newSchedules);
        return redirect()->back()->with('status', 'Schedule saved successfully');
    }

    public function fees($id)
    {
        $isEdit = true;
        $user = User::find($id);

        return view('admin.modules.therapist.fees', [
            'isEdit' => $isEdit,
            'user' => $user
        ]);
    }

    public function feesStore(Request $request)
    {
        $params = $request->except(['_token']);

        $user = $this->userService->get($params['id']);
        $this->userService->saveTherapistProfile($user, $params);

        return redirect()
            ->back()
            ->with('status', 'Fees saved successfully.');
    }

    public function holidays($id)
    {
        $isEdit = true;
        $holidays = TherapistHoliday::paginate();

        $user = User::find($id);

        return view('admin.modules.therapist.holidays', [
            'isEdit' => $isEdit,
            'holidays' => $holidays,
            'user' => $user
        ]);
    }
}

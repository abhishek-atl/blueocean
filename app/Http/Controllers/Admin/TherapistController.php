<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;

use App\Models\PostcodeZone;
use App\Models\PostcodeDistrict;
use App\Models\TherapistHoliday;
use App\Models\Treatment;
use App\Models\User;

use App\Services\BookingService;
use App\Services\DatabaseService;
use App\Services\UploadService;
use App\Services\UserService;

class TherapistController extends Controller
{
    protected $uploadService;
    protected $bookingService;
    protected $userService;
    protected $databaseService;

    public function __construct(
        UploadService $uploadService,
        BookingService $bookingService,
        UserService $userService,
        DatabaseService $databaseService
    ) {
        $this->uploadService = $uploadService;
        $this->bookingService = $bookingService;
        $this->userService = $userService;
        $this->databaseService = $databaseService;
    }

    public function index(Request $request)
    {
        $params = [];
        $params['sort_by'] = $request->get('sort_by', 'id');
        $params['sort_order'] = $request->get('sort_order', 'desc');
        if (null != $request->get('search')) {
            $params['search'] = $request->get('search');
        }

        $therapists = $this->userService->therapists($params);
        return view('admin.modules.therapist.index', [
            'therapists' => $therapists,
            'sort_by' => $params['sort_by'],
            'sort_order' => $params['sort_order']
        ]);
    }

    public function createEdit($id = null)
    {
        $user = null;
        if ($id) {
            $user = $this->userService->find($id);
            $user->load(['user_profile', 'therapist_profile']);
        }

        return view('admin.modules.therapist.create_edit', [
            'user' => $user,
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $params = $request->except(['_token', 'image']);

        $params['user_type'] = User::TYPE_THERAPIST;
        $params['email_verified_at'] = now();
        $user = $this->userService->save($params);
        $this->userService->saveUserProfile($user, $params);

        if ($request->has('image')) {
            $file = $request->file('image');
            $uploadPath = config('custom.upload.user_path');
            $path = $this->uploadService->upload($file, $uploadPath);
            $this->userService->saveUserImage($user, $path);
        }

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
        $user = $this->userService->find($id);
        $user->user_profile()->delete();
        $user->therapist_profile()->delete();
        $user->treatments()->detach();
        $user->postcodes()->detach();
        $user->holidays()->delete();
        $user->schedule()->delete();
        $user->delete();

        return redirect()
            ->back()
            ->with('status', 'Therapist deleted successfully.');
    }

    public function therapistProfile($id)
    {
        $user = null;
        if ($id) {
            $user = $this->userService->find($id);
            $user->load(['user_profile', 'therapist_profile']);
        }

        return view('admin.modules.therapist.profile', [
            'user' => $user,
        ]);
    }

    public function therapistProfileStore(Request $request)
    {
        $params = $request->except(['_token', 'image']);

        $user = $this->userService->find($params['id']);
        $this->userService->saveTherapistProfile($user, $params);

        return redirect()
            ->back()
            ->with('status', 'Therapist updated successfully.');
    }

    public function treatments($id)
    {
        $user = $this->userService->find($id);
        $user->load(['treatments', 'user_profile']);

        $treatments = $this->databaseService->getByParams(Treatment::class, ['all' => true]);
        return view('admin.modules.therapist.treatments', [
            'treatments' => $treatments,
            'user' => $user
        ]);
    }

    public function treatmentsStore(Request $request)
    {
        $user = $this->userService->find(request('id'));
        $user->treatments()->sync($request->treatments);
        return redirect()->back()->with('status', 'Treatments updated successfully');
    }

    public function postcodes($id)
    {
        $user = $this->userService->find(request('id'));
        $user->load('postcodes');

        $districts = $this->databaseService->getByParams(PostcodeDistrict::class, ['all' => true]);
        $zones = $this->databaseService->getByParams(PostcodeZone::class, ['all' => true]);

        return view('admin.modules.therapist.postcodes', [
            'districts' => $districts,
            'user' => $user,
            'zones' => $zones
        ]);
    }

    public function postcodesStore(Request $request)
    {
        $user = $this->userService->find(request('id'));
        $user->postcodes()->sync($request->postcodes);
        return redirect()->back()->with('status', 'Postcodes updated successfully');
    }

    public function schedules($id)
    {
        $user = $this->userService->find(request('id'));
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
            'user' => $user,
            'timeSlots' => $timeSlots,
            'days' => $days
        ]);
    }

    public function schedulesStore(Request $request)
    {
        $user = $this->userService->find(request('id'));
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
        $user = $this->userService->find($id);

        return view('admin.modules.therapist.fees', [
            'user' => $user
        ]);
    }

    public function feesStore(Request $request)
    {
        $params = $request->except(['_token']);

        $user = $this->userService->find($params['id']);
        $this->userService->saveTherapistProfile($user, $params);

        return redirect()
            ->back()
            ->with('status', 'Fees saved successfully.');
    }

    public function holidays($id)
    {
        $params = [];
        $params['where'] = ['user_id' => $id];
        $holidays = $this->databaseService->getByParams(TherapistHoliday::class, $params);

        $user = $this->userService->find($id);

        return view('admin.modules.therapist.holidays', [
            'holidays' => $holidays,
            'user' => $user
        ]);
    }
}

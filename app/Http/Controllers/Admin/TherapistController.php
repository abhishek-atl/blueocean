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



class TherapistController extends Controller
{
    protected $uploadService;
    protected $bookingService;

    public function __construct(
        UploadService $uploadService,
        BookingService $bookingService
    ) {
        $this->uploadService = $uploadService;
        $this->bookingService = $bookingService;
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
        $params = $request->except('_token');

        if (isset($params['id'])) {
            $therapist = User::findOrFail($params['id']);
            $therapist->update($params);
            $message = 'Therapist updated successfully.';
        } else {
            $therapist = User::create($params);
            $message = 'Therapist added successfully.';
        }

        return redirect()
            ->route('admin.therapists.edit', ['id' => $therapist->id])
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

    public function treatmentsStore() {}

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

    public function postcodesStore() {}

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

    public function schedulesStore() {}

    public function fees($id)
    {
        $isEdit = true;
        $user = User::find($id);

        return view('admin.modules.therapist.fees', [
            'isEdit' => $isEdit,
            'user' => $user
        ]);
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

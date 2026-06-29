<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserService
{

    protected MailService $mailService;

    public function __construct(
        MailService $mailService,
    ) {
        $this->mailService = $mailService;
    }

    function logout($request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return true;
    }

    public function sendVerificationLink($id)
    {

        $user = User::whereId($id)->first();
        $token = Str::random(64);
        UserVerify::create([
            'user_id' => $user->id,
            'token' => $token
        ]);
        $this->mailService->sendMailVerifyEmail($user, $token);

        return true;
    }

    public function rateTherapist($bookingId, $score)
    {
        $result = false;
        try {
            $booking = Booking::whereId($bookingId)->with('therapist')->first();
            $booking->update([
                'therapist_rating' => $score
            ]);
            $avg = $booking->therapist->bookings()
                ->whereNotNull('therapist_rating')
                ->avg('therapist_rating');
            $booking->therapist->update([
                'avg_rating' => number_format($avg, 2)
            ]);
            $result = true;
        } catch (Exception $e) {
        }
        return $result;
    }

    public function rateCustomer($bookingId, $score)
    {
        $result = false;
        try {
            $booking = Booking::whereId($bookingId)->with('client')->first();
            $booking->update([
                'client_rating' => $score
            ]);
            if ($booking->client) {
                $avg = $booking->client->client_bookings()
                    ->whereNotNull('client_rating')
                    ->avg('client_rating');
                $booking->client->update([
                    'avg_rating' => number_format($avg, 2)
                ]);
            }
            $result = true;
        } catch (Exception $e) {
        }
        return $result;
    }

    public function admins($params)
    {
        $query = User::where('user_type', 'Admin')->with('user_profile');

        if (isset($params['search'])) {
            $query->where('first_name', 'like', $params['search']);
        }

        $sortBy = isset($params['sort_by']) ?  $params['sort_by'] : 'created_at';
        $sortOrder = (isset($params['sort_order']) && $params['sort_order'] === 'asc') ? 'asc' : 'desc';

        $query->orderBy($sortBy, $sortOrder);

        if (isset($params['all'])) {
            return $query->get();
        } else {
            return $query->paginate(config('custom.db.per_page'));
        }
    }

    public function therapists($params)
    {
        $query = User::where('user_type', 'Therapist')->with('user_profile');

        if (isset($params['search'])) {
            $query->where('first_name', 'like', $params['search']);
        }

        $sortBy = isset($params['sort_by']) ?  $params['sort_by'] : 'created_at';
        $sortOrder = (isset($params['sort_order']) && $params['sort_order'] === 'asc') ? 'asc' : 'desc';

        $query->orderBy($sortBy, $sortOrder);

        if (isset($params['all'])) {
            return $query->get();
        } else {
            return $query->paginate(config('custom.db.per_page'));
        }
    }

    public function customers($params)
    {
        $query = User::where('user_type', 'Customer')->with('user_profile');

        if (isset($params['search'])) {
            $query->where('first_name', 'like', $params['search']);
        }

        $sortBy = isset($params['sort_by']) ?  $params['sort_by'] : 'created_at';
        $sortOrder = (isset($params['sort_order']) && $params['sort_order'] === 'asc') ? 'asc' : 'desc';

        $query->orderBy($sortBy, $sortOrder);

        if (isset($params['all'])) {
            return $query->get();
        } else {
            return $query->paginate(config('custom.db.per_page'));
        }
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function save($params)
    {
        if (isset($params['password'])) {
            $params['password'] = bcrypt($params['password']);
        } else {
            unset($params['password']);
        }

        if (isset($params['id'])) {
            $user = User::findOrFail($params['id']);
            $user->update($params);
        } else {
            $user = User::create($params);
        }
        return $user;
    }

    public function saveUserProfile($user, $params)
    {
        $params['birthday'] = Carbon::createFromFormat(config('custom.format.date_short'), $params['birthday']);
        $user->user_profile()->updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'mobile' => $params['mobile'],
                'birthday' => $params['birthday'],
                'flat_no' => $params['flat_no'],
                'street_no' => $params['street_no'],
                'street_name' => $params['street_name'],
                'town' => $params['town'],
                'postcode' => $params['postcode'],
            ]
        );
    }

    public function saveUserImage($user, $image)
    {
        $user->user_profile()->update(['image' => $image]);
    }

    public function saveTherapistProfile($user, $params)
    {
        if (isset($params['health_renewal_date'])) {
            $params['health_renewal_date'] = Carbon::createFromDate(config('custom.format.date_short'), $params['health_renewal_date']);
        }
        $user->therapist_profile()->updateOrCreate(
            [
                'user_id' => $user->id
            ],
            $params
        );
    }

    public function saveSchedule($user, $params)
    {
        $user->schedule()->updateOrCreate(
            [
                'user_id' => $user->id
            ],
            $params
        );
    }
}

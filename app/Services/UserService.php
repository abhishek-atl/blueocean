<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\ClientReview;
use App\Models\TherapistReview;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

    public function rateTherapist(User $client, int $bookingId, array $ratings, ?string $ipAddress): TherapistReview
    {
        return DB::transaction(function () use ($client, $bookingId, $ratings, $ipAddress) {
            $booking = Booking::query()
                ->whereKey($bookingId)
                ->where('user_id', $client->id)
                ->with('therapist.therapist_profile')
                ->firstOrFail();

            $average = round(collect($ratings)->only([
                'eval_punctuality',
                'eval_professionalism',
                'eval_communication',
                'eval_technique',
            ])->average());

            $review = TherapistReview::updateOrCreate(
                ['booking_id' => $booking->id],
                array_merge($ratings, [
                    'therapist_id' => $booking->therapist_id,
                    'client_id' => $client->id,
                    'avg_evaluation' => $average,
                    'ip_address' => $ipAddress ?: '',
                ])
            );

            $therapistAverage = TherapistReview::query()
                ->where('therapist_id', $booking->therapist_id)
                ->avg('avg_evaluation');

            $booking->therapist->therapist_profile()->update([
                'avg_rating' => round($therapistAverage, 1),
            ]);

            return $review;
        });
    }

    public function rateClient(User $therapist, int $bookingId, array $ratings, ?string $ipAddress): ClientReview
    {
        return DB::transaction(function () use ($therapist, $bookingId, $ratings, $ipAddress) {
            $booking = Booking::query()
                ->whereKey($bookingId)
                ->where('therapist_id', $therapist->id)
                ->whereNotNull('user_id')
                ->with('client.user_profile')
                ->firstOrFail();

            $average = round(collect($ratings)->only([
                'eval_respectful_behaviour',
                'eval_communication',
                'eval_booking_information_accuracy',
                'eval_treatment_space_suitability',
            ])->average(), 1);

            $review = ClientReview::updateOrCreate(
                ['booking_id' => $booking->id],
                array_merge($ratings, [
                    'therapist_id' => $therapist->id,
                    'client_id' => $booking->user_id,
                    'avg_evaluation' => $average,
                    'ip_address' => $ipAddress,
                ])
            );

            $clientAverage = ClientReview::query()
                ->where('client_id', $booking->user_id)
                ->avg('avg_evaluation');

            $booking->client->user_profile()->update([
                'avg_rating' => round($clientAverage, 1),
            ]);

            return $review;
        });
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

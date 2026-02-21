<?php

namespace App\Services;

use App\Models\User;

class UserService
{
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
        $params['birthday'] = \Carbon\Carbon::createFromDate($params['birthday']);
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
        if(isset($params['health_renewal_date'])) {
            $params['health_renewal_date'] = \Carbon\Carbon::createFromDate($params['health_renewal_date']);
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

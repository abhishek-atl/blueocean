<?php

namespace App\Services;

use App\Models\User;

class UserService
{

    public function get($id)
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

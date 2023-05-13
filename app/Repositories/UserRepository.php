<?php

namespace App\Repositories;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function getUserByUsername($username)
    {
        // If $username empty string
        if ($username == '') {
            return [];
        }

        // Else empty string
        $users = User::where('username', 'LIKE', '%'.$username.'%')
                    ->where('username', '<>', Auth::user()->username)
                    ->get(['id', 'avatar', 'name', 'username']);

        return $users;
    }

    public function getProfileByUsername($username)
    {
        $user = User::where('username', $username)
                    ->firstOrFail();

        $formated = (object) [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => asset('avatars') . '/' . $user->avatar,
            'username' => $user->username,
            'phone_number' => $user->phone_number,
            'bio' => $user->bio,
            'platform' => $user->platform
        ];

        return $formated;
    }
}

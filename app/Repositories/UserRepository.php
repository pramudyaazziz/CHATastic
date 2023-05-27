<?php

namespace App\Repositories;

use App\Models\Conversation;
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

        $conversations = Conversation::where('user_one', Auth::user()->id)
                            ->orWhere('user_two', Auth::user()->id)
                            ->get();

        $formated = $this->formatUserData($users, $conversations);

        return $formated;
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

    private function formatUserData($users, $conversations) {
        $formated = [];

        foreach ($users as $user) {
            $conversation_id = null;

            foreach ($conversations as $conversation) {
                $hasConversation = $conversation->user_one == $user->id || $conversation->user_two == $user->id;

                if ($hasConversation) {
                    $conversation_id = $conversation->id;
                }
            }

            $formated[] = (object) [
                'id' => $user->id,
                'avatar' => asset('avatars/' . $user->avatar),
                'name' => $user->name,
                'username' => $user->username,
                'conversation_id' => $conversation_id
            ];
        }

        return $formated;
    }
}

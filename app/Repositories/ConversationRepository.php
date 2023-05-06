<?php

namespace App\Repositories;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ConversationRepository
{
    public function getChatHistory()
    {
        $chatHistory = Conversation::where('user_one', Auth::user()->id)
            ->orWhere('user_two', Auth::user()->id)
            ->get()
            ->map(function ($conversation) {
                return $this->formatChatHistory($conversation);
            });

        return $chatHistory;
    }

    public function getUserbyUsername($username)
    {
        if ($username == '') {
            return [];
        }

        $users = User::where('username', 'LIKE', '%'.$username.'%')
                    ->where('username', '<>', Auth::user()->username)
                    ->get(['id', 'avatar', 'name', 'username']);

        return $users;
    }

    public function formatChatHistory($conversation)
    {
        $interlocutor_id = ($conversation->user_one == Auth::user()->id) ? $conversation->user_two : $conversation->user_one;
        return [
            'id' => $conversation->id,
            'interlocutor' => User::where('id', $interlocutor_id)
                                ->select(['id', 'name', 'avatar'])
                                ->firstOrFail(),
            'last_message' => $conversation->lastMessage->body,
            'unread_messages' => count($conversation->unreadMessages)
        ];
    }
}

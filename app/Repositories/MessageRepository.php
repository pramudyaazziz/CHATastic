<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

class MessageRepository
{
    public function storeMessage($request, $conversation)
    {
        $message = $conversation->messages()->create([
            'from_id' => Auth::user()->id,
            'to_id' => $conversation->user_one == Auth::user()->id ? $conversation->user_two : $conversation->user_one,
            'body' => $request->text,
            'type' => 'text',
            'is_read' => false
        ]);

        return $message;
    }

    public function formatMessage($message)
    {
        return (object) [
            'id' => $message->id,
            'conversation_id' => $message->conversation_id,
            'from_id' => $message->from_id,
            'to_id' => $message->to_id,
            'body' => $message->body,
            'type' => $message->type,
            'time' => $this->formatDate($message->created_at)
        ];
    }

    public function markAsRead($message)
    {
        $msg = $message->update([
            'is_read' => true
        ]);

        return $msg;
    }

    private function formatDate($created_at)
    {
        if ($created_at->isToday()) {
            return 'Today '.$created_at->format('H:i');
        } elseif ($created_at->isYesterday()) {
            return 'Yesterday '.$created_at->format('H:i');
        } else {
            return $created_at->format('d/m/Y H:i');
        }
    }
}

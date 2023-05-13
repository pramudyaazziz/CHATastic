<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class)
                        ->select(['id', 'body', 'is_read'])
                        ->where('is_read', false)
                        ->where('from_id', '<>' , Auth::user()->id);
    }
}

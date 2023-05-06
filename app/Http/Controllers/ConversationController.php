<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Repositories\ConversationRepository;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    protected $conversation;

    public function __construct(ConversationRepository $conversation)
    {
        $this->conversation = $conversation;
    }

    public function index()
    {
        return Inertia::render('Conversation/Main', [
            'chatHistory' => $this->conversation->getChatHistory()
        ]);
    }

    public function getUser(Request $request)
    {
        $users = $this->conversation->getUserbyUsername($request->username);

        return response()->json([
            'users' => $users
        ], 200);
    }
}

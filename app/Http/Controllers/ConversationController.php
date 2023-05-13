<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Conversation;
use Inertia\Inertia;
use App\Repositories\ConversationRepository;
use App\Repositories\UserRepository;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    protected $conversation;
    protected $user;
    protected $message;

    public function __construct(ConversationRepository $conversation, UserRepository $user, MessageRepository $message)
    {
        $this->conversation = $conversation;
        $this->user = $user;
        $this->message = $message;
    }

    public function index()
    {
        return Inertia::render('Conversation/Main', [
            'chatHistory' => $this->conversation->getChatHistory()
        ]);
    }

    public function getUser(Request $request)
    {
        $users = $this->user->getUserByUsername($request->username);

        return response()->json([
            'users' => $users
        ], 200);
    }

    public function getConversation($id)
    {
        $conversation = $this->conversation->getConversationById($id);

        return response()->json([
            'conversation' => $conversation
        ], 200);
    }

    public function getProfile($username)
    {
        try {
            $user = $this->user->getProfileByUsername($username);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'code' => 404,
                'messages' => 'Data not found'
            ], 404);
        }

        return response()->json($user, 200);
    }

    public function storeMessageConversation(Request $request, Conversation $conversation)
    {
        if ($request->text) {
            $msg = $this->message->storeMessage($request, $conversation);
            $message = $this->message->formatMessage($msg);
            broadcast(new NewMessage($message))->toOthers();
            return response()->json($message);
        }

    }
}

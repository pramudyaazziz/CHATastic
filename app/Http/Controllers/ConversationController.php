<?php

namespace App\Http\Controllers;

use App\Events\Conversation as EventsConversation;
use App\Events\NewMessageEvent;
use App\Models\Conversation;
use App\Models\Message;
use Inertia\Inertia;
use App\Repositories\ConversationRepository;
use App\Repositories\UserRepository;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use App\Events\ConversationEvent;
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
            broadcast(new NewMessageEvent($message))->toOthers();
            broadcast(new ConversationEvent($message));
            return response()->json($message);
        }

    }

    public function markAsRead(Message $message)
    {
        $msg = $this->message->markAsRead($message);
        return response()->json($msg, 200);
    }

    public function chatHistory()
    {
        $chatHistory = $this->conversation->getChatHistory();

        return response()->json($chatHistory, 200);
    }
}

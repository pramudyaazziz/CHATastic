<?php

namespace App\Http\Middleware;

use App\Models\Conversation;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ConversationMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $conversationId = $request->route('conversation');

        try {

            $conversation = Conversation::findOrFail($conversationId);

        } catch (\Throwable $th) {

            return $this->responseFailed();

        }

        if ($conversation->user_one == Auth::user()->id || $conversation->user_two == Auth::user()->id) {
            return $next($request);
        }

        return $this->responseFailed();
    }

    private function responseFailed()
    {
        return response()->json([
            'status' => 'failed',
            'code' => 404,
            'message' => "Data not found"
        ], 404);
    }
}

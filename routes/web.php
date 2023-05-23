<?php

use App\Http\Controllers\ConversationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [ConversationController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'updatePersonal'])->name('update.personal.profile');
    Route::patch('/profile/socialmedia', [ProfileController::class, 'updateSocial'])->name('update.social.media');
    Route::post('profile/avatar', [ProfileController::class, 'avatar'])->name('avatar.update');

    // Fetch user by username for new Message feature
    Route::get('/users/get', [ConversationController::class, 'getUser'])->name('chat.new');

    // Fetch conversation by Id
    Route::get('/conversation/{conversation}', [ConversationController::class, 'getConversation'])->name('conversation.show')->middleware('conversation.member');

    // Fetch user profile
    Route::get('/user/profile/{user}', [ConversationController::class, 'getProfile'])->name('profile.detail');

    // Store message with conversation
    Route::post('/message/{conversation}', [ConversationController::class, 'storeMessageConversation'])->name('store.message.conversation');

    // Store message without conversation
    Route::post('/message/{interlocutor}', [ConversationController::class, 'storeMessageInterlocutor'])->name('store.message.interlocutor');

    // Mark as read message
    Route::get('/conversation/read/{message}', [ConversationController::class, 'markAsRead'])->name('mark.read');

    // Fetch a new chatHistory for sidebar
    Route::get('/my-conversation', [ConversationController::class, 'chatHistory'])->name('chat.history');
});

require __DIR__.'/auth.php';

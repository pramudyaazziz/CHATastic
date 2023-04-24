<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(): Response
    {
        return Inertia::render('Conversation/Profile', [
            'status' => session('status'),
            'user' => User::find(Auth::user()->id)->load('platform'),
        ]);
    }

    /**
     * Update the user's avatar.
     */
    public function avatar(Request $request)
    {
        $request->validate(['file' => 'required|mimes:png,jpg|max:2048']);

        $default = $request->user()->avatar == 'default.png';
        $file = $request->file('file');
        if ($default) {
            $file_name = uniqid('avatar-') . '.' . $file->getClientOriginalExtension();
            $request->user()->update(['avatar' => $file_name]);
        }
        $file->move('avatars', $request->user()->avatar);

        return back();
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = User::find(Auth::user()->id);
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'facebook' => 'nullable|active_url',
            'phone_number' => 'nullable|numeric|digits_between:11,13|unique:users,username,' . $user->id,
            'bio' => 'required|max:100',
        ]);

        if ($request->twitter || $request->facebook || $request->instagram) {
            $user->platform()->update([
                'twitter' => $request->twitter,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
            ]);
        }

        $user->update($request->all());

        session()->flash('status', 'Profile has been updated successfully.');

        return Redirect::route('profile.edit');
    }
}

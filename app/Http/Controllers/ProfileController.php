<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvatarRequest;
use App\Http\Requests\PersonalProfileRequest;
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
        $user = Auth::user();
        $user->platform;

        return Inertia::render('Conversation/Profile', [
            'status' => session('status'),
            'user' => $user,
        ]);
    }

    /**
     * Update the user's avatar.
     */
    public function avatar(AvatarRequest $request)
    {
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
     * Update the user's personal profile information.
     */
    public function updatePersonal(PersonalProfileRequest $request): RedirectResponse
    {
        Auth::user()->update($request->all());

        session()->flash('status', 'Personal profile has been updated.');

        return Redirect::route('profile.edit');
    }

      /**
     * Update the user's social media profile.
     */
    public function updateSocial(Request $request)
    {
        $request->validate([
            'facebook' => 'nullable|active_url',
        ]);

        if ($request->twitter || $request->facebook || $request->instagram) {
            Auth::user()->platform()->update([
                'twitter' => $request->twitter,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
            ]);
        }

        session()->flash('status', 'Social Media has been updated.');

        return Redirect::route('profile.edit');
    }
}

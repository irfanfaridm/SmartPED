<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        return view('profile.show', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar with proper validation
            $file = $request->file('avatar');
            
            // Validate file type
            if (!$file->isValid()) {
                return Redirect::back()->withErrors(['avatar' => 'File upload tidak valid.'])->withInput();
            }

            // Generate unique filename
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $avatarPath = $file->storeAs('avatars', $filename, 'public');
            
            if (!$avatarPath) {
                return Redirect::back()->withErrors(['avatar' => 'Gagal menyimpan file avatar.'])->withInput();
            }
            
            // Debug: Log the avatar path
            \Log::info('Avatar uploaded successfully', [
                'user_id' => $user->id,
                'avatar_path' => $avatarPath,
                'full_url' => Storage::url($avatarPath),
                'file_exists' => Storage::disk('public')->exists($avatarPath)
            ]);
            
            $data['avatar'] = $avatarPath;
        }

        // Fill user data
        $user->fill($data);

        // Handle email verification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Save user
        $user->save();

        return Redirect::route('profile.show')->with('status', 'profile-updated');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Delete avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Remove user's avatar.
     */
    public function removeAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        return Redirect::route('profile.edit')->with('status', 'avatar-removed');
    }
}

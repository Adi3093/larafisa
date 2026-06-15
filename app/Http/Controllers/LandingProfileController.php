<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class LandingProfileController extends Controller
{
    public function index()
    {
        return view('landing_page.hprofile');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('landing_page.hedit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|string|max:45',
            'username' => 'required|string|max:45|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:45|unique:users,email,' . $user->id,
            'no_ktp' => 'nullable|string|max:16|unique:users,no_ktp,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'password' => 'nullable|string|min:8',
        ]);

        $data = $request->except(['password', 'avatar']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);
        return redirect()->route('profil.tamu')->with('success', 'Data profil berhasil diperbarui!');
    }
}

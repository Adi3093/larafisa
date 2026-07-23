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

    // 1. FUNGSI UPDATE PROFIL (Tanpa Password)
    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|string|max:45',
            'username' => 'required|string|max:45|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:45|unique:users,email,' . $user->id,
            'no_ktp' => 'nullable|string|max:16|unique:users,no_ktp,' . $user->id,
            'no_hp' => 'nullable|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $data = $request->except(['avatar', 'no_hp']);

        // Rapikan format No HP (Otomatis ubah 08.. jadi 628..)
        if ($request->filled('no_hp')) {
            $noHp = $request->no_hp;
            if (substr($noHp, 0, 1) === '0') {
                $noHp = '62' . substr($noHp, 1);
            } elseif (substr($noHp, 0, 2) !== '62') {
                $noHp = '62' . $noHp;
            }
            $data['no_hp'] = $noHp;
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);
        return redirect()->route('profil.tamu')->with('success', 'Data profil berhasil diperbarui!');
    }

    // 2. FUNGSI TAMPILKAN HALAMAN UBAH PASSWORD
    public function password()
    {
        return view('landing_page.hpassword');
    }

    // 3. FUNGSI UPDATE PASSWORD
    public function updatePassword(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profil.tamu')->with('success', 'Kata sandi berhasil diperbarui!');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{
    // =====================================================================
    // MODULE 1: RENDER SETTINGS PAGE
    // Memuat halaman pengaturan dasar (Sistem & Profil)
    // =====================================================================
    public function index()
    {
        return view('dashboard.settings');
    }

    // =====================================================================
    // MODULE 2: UPDATE INFORMASI PROFIL
    // Memperbarui Username, Password, Email, & Upload Avatar
    // =====================================================================
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:45',
            'username' => 'required|string|max:20|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        // Hanya di-hash dan diubah jika pengguna mengetikkan password baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return back()->with('success', 'Profil sistem Anda berhasil diperbarui!');
    }

    // =====================================================================
    // MODULE 3: UPDATE JADWAL MAINTENANCE SERVER
    // Menyimpan konfigurasi toggle maintenance ke dalam File Cache
    // =====================================================================
    public function updateMaintenance(Request $request)
    {
        // Fitur ini sebenarnya dilindungi middleware route 'admin',
        // tapi logika ini mengunci variabel cache yang mengatur jalan tidaknya web.
        
        Cache::forever('maintenance_mode', $request->maintenance_mode ? 'true' : 'false');
        Cache::forever('main_online', $request->main_online ? 'true' : 'false');
        Cache::forever('main_walkin', $request->main_walkin ? 'true' : 'false');

        Cache::forever('jadwal_maintenance', $request->jadwal_maintenance ? 'true' : 'false');
        Cache::forever('auto_maintenance', $request->auto_maintenance ? 'true' : 'false');
        Cache::forever('check_jadwal_online', $request->check_jadwal_online ? 'true' : 'false');
        Cache::forever('check_jadwal_walkin', $request->check_jadwal_walkin ? 'true' : 'false');

        Cache::forever('jadwal_tersimpan', $request->jadwal_tersimpan);

        return response()->json(['success' => true]);
    }
}
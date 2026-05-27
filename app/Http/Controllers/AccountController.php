<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        // Tangkap input dari URL (jika ada)
        $search = $request->search;
        $perPage = $request->per_page ?? 5; // Default 5 baris per halaman

        // Mulai merakit query (Hanya Admin & Resepsionis)
        $query = User::whereIn('role', ['admin', 'resepsionis']);

        // Jika ada input pencarian, filter datanya
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Jalankan Pagination dan bawa serta parameter URL sebelumnya (appends)
        $admins = $query->paginate($perPage)->appends($request->all());

        return view('dashboard.akun', compact('admins', 'search', 'perPage'));
    }

    // Memproses Tambah Akun Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'role' => 'required|in:admin,resepsionis',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Akun ' . $request->name . ' berhasil ditambahkan!');
    }

    // Memproses perubahan data dari Pop-up Modal (Tetap seperti sebelumnya)
    public function update(Request $request, $id)
    {
        $targetUser = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'password' => 'nullable|min:8',
        ]);

        $targetUser->username = $request->username;

        if ($request->filled('password')) {
            $targetUser->password = Hash::make($request->password);
        }

        $targetUser->save();

        return back()->with('success', 'Akun ' . $targetUser->name . ' berhasil diperbarui!');
    }
}

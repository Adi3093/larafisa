<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 10;
        $search = $request->search;
        $tab = $request->tab ?? 'admin';
        $query = User::query();

        if ($tab === 'tamu') {
            $query->where('role', 'tamu');
        } else {
            $query->whereIn('role', ['admin', 'resepsionis', 'owner']);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate($perPage)->appends($request->query());
        return view('dashboard.akun', compact('users', 'perPage', 'search', 'tab'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'role' => 'required|in:admin,resepsionis,owner', 
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

    public function update(Request $request, $id)
    {
        $targetUser = User::findOrFail($id);

        if ($targetUser->role === 'tamu') {
            return back()->withErrors(['Akses Ditolak: Anda tidak diizinkan untuk mengubah data privasi milik Tamu.']);
        }

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
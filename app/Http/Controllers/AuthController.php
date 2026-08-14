<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // PERBAIKAN: Mengarahkan Admin, Resepsionis, dan Owner ke halaman Dashboard
            if (in_array(Auth::user()->role, ['admin', 'resepsionis', 'owner'])) {
                return redirect()->intended('/dashboard');
            }

            // Jika Tamu, arahkan ke Landing Page
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login' => 'Username/Email atau Password salah.',
        ])->onlyInput('login');
    }

    //Resgistrasi Tamu
    public function register()
    {
        return view('auth.register');
    }
    public function register_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:45',
            'email' => 'required|string|email|max:45|unique:users',
            'password' => 'required|string|min:8|confirmed', // <-- Tambahkan |confirmed di sini
        ]);

        $baseUsername = Str::before($request->email, "@");
        $username = $baseUsername;

        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'password' => $request->password, // (Optional) Bisa pakai $request->password saja karena di User model sudah ada 'hashed'
            'role' => 'tamu',
        ]);

        Auth::login($user);
        return redirect('/');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Cek role user dan arahkan sesuai rolenya
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Selamat datang, Admin! Anda berhasil masuk ke panel admin.');
            } else {
                // User biasa diarahkan langsung ke halaman profil
                return redirect()->route('profile.edit')
                    ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak valid.',
        ])->onlyInput('email');
    }

    /**
     * Show the registration form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Pastikan setiap user yang mendaftar mendapat role 'user'
        ]);

        Auth::login($user);

        return redirect()->route('profile.edit')
            ->with('success', 'Selamat datang, ' . $user->name . '! Akun Anda berhasil dibuat. Silakan lengkapi profil Anda.');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'Anda telah berhasil logout. Sampai jumpa!');
    }
}

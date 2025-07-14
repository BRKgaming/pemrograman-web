<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ValidatorAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.validator-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (!Auth::guard('validator')->attempt($request->only('username', 'password'))) {
            throw ValidationException::withMessages([
                'username' => ['Username or Password incorrect'],
            ]);
        }

        return redirect()->route('validator.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('validator')->logout();
        return redirect()->route('validator.login.form');
    }
}
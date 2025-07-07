<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SocietyAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.society-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'id_card_number' => 'required|string|size:8',
            'password' => 'required|string',
        ]);

        $society = Society::where('id_card_number', $request->id_card_number)->first();

        if (!$society || !Hash::check($request->password, $society->password)) {
            throw ValidationException::withMessages([
                'id_card_number' => ['ID Card Number or Password incorrect'],
            ]);
        }

        $token = $society->generateToken();

        Auth::guard('society')->login($society);

        return redirect()->route('society.dashboard');
    }

    public function logout(Request $request)
    {
        $society = Auth::guard('society')->user();

        if ($society) {
            $society->login_tokens = null;
            $society->save();
            Auth::guard('society')->logout();
        }

        return redirect()->route('society.login.form');
    }
}

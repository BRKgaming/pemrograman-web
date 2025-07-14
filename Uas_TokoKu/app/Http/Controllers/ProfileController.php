<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Membuat validasi dasar
        $rules = $this->getValidationRules($user, $request);
        
        // Validasi input
        $validated = $request->validate($rules);
        
        // Proses update profil
        $this->updateUserProfile($user, $validated, $request);
        
        // Jika ada permintaan update password, proses disini
        if (isset($validated['password'])) {
            $passwordResult = $this->updateUserPassword($user, $validated);
            if ($passwordResult !== true) {
                return $passwordResult;
            }
        }
        
        // Simpan perubahan
        $user->save();
        
        // Redirect kembali dengan pesan sukses
        return redirect()
            ->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui.');
    }
    
    /**
     * Mendapatkan aturan validasi untuk update profil.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getValidationRules(User $user, Request $request): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'address' => ['nullable', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:20'],
            'city' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'required_with:password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
        
        // Tambahkan validasi avatar jika ada upload file
        if ($request->hasFile('avatar')) {
            $rules['avatar'] = ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'];
        }
        
        return $rules;
    }
    
    /**
     * Memperbarui profil pengguna dengan data yang tervalidasi.
     *
     * @param  \App\Models\User  $user
     * @param  array  $validated
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function updateUserProfile(User $user, array $validated, Request $request): void
    {
        // Update informasi dasar
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->address = $validated['address'] ?? $user->address;
        $user->phone = $validated['phone'] ?? $user->phone;
        $user->city = $validated['city'] ?? $user->city;
        $user->postal_code = $validated['postal_code'] ?? $user->postal_code;
        
        // Proses upload avatar jika ada
        if ($request->hasFile('avatar')) {
            $this->updateUserAvatar($user, $request);
        }
    }
    
    /**
     * Memperbarui avatar pengguna.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function updateUserAvatar(User $user, Request $request): void
    {
        // Hapus avatar lama jika ada
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        
        // Upload dan simpan avatar baru
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $avatarPath;
    }
    
    /**
     * Memperbarui password pengguna.
     *
     * @param  \App\Models\User  $user
     * @param  array  $validated
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    protected function updateUserPassword(User $user, array $validated)
    {
        // Verifikasi password saat ini
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini tidak cocok.'])
                ->withInput();
        }
        
        // Update password
        $user->password = Hash::make($validated['password']);
        
        return true;
    }
}

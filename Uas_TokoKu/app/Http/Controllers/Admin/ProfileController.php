<?php

namespace App\Http\Controllers\Admin;

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
     * Show the admin profile.
     */
    public function index()
    {
        // Pastikan user adalah admin
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }
        
        return view('admin.profile.index');
    }

    /**
     * Update profile information.
     */
    public function update(Request $request)
    {
        // Pastikan user adalah admin
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }
        
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);
        
        $user->update($request->only(['name', 'phone', 'address', 'city', 'postal_code']));
        
        return redirect()->route('admin.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update avatar/profile picture.
     */
    public function updateAvatar(Request $request)
    {
        // Pastikan user adalah admin
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }
        
        $user = Auth::user();
        
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::exists('public/avatars/' . basename($user->avatar))) {
                Storage::delete('public/avatars/' . basename($user->avatar));
            }
            
            // Simpan avatar baru
            $avatarName = time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('public/avatars', $avatarName);
            
            $user->avatar = 'storage/avatars/' . $avatarName;
            $user->save();
        }
        
        return redirect()->route('admin.profile')->with('success', 'Foto profil berhasil diperbarui.');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        // Pastikan user adalah admin
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak.');
        }
        
        $user = Auth::user();
        
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // Verifikasi password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
        }
        
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('admin.profile')->with('success', 'Password berhasil diperbarui.');
    }
}

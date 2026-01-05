<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // ✅ Update ke tabel users (email + password jika diisi)
        $userData = [];

        if ($request->filled('email')) {
            $userData['email'] = $request->email;
        }

        // Ganti password jika diminta
        if ($request->filled('password_lama') && $request->filled('password_baru')) {
            if (!Hash::check($request->password_lama, $user->password)) {
                return response()->json(['success' => false, 'field' => 'password_lama', 'message' => 'Password lama salah.']);
            }

            if ($request->password_baru !== $request->konfirmasi_password) {
                return response()->json(['success' => false, 'field' => 'konfirmasi_password', 'message' => 'Konfirmasi password tidak cocok.']);
            }

            $userData['password'] = Hash::make($request->password_baru);
        }

        $user->update($userData);

        // ✅ Update ke tabel profiles
        $profileData = $request->only(['nama', 'alamat', 'nomor']);

        // Simpan foto profil jika ada
        if ($request->hasFile('fotoProfil')) {
            $foto = $request->file('fotoProfil');
            $filename = $user->username . '.' . $foto->getClientOriginalExtension();

            // Hapus foto lama jika ada
            if ($user->profile->foto && File::exists(public_path('foto-profile/' . $user->profile->foto))) {
                File::delete(public_path('foto-profile/' . $user->profile->foto));
            }

            $foto->move(public_path('foto-profile'), $filename);
            $profileData['foto'] = $filename;
        }

        $user->profile()->update($profileData);

        return response()->json(['success' => true, 'message' => 'Data profil berhasil disimpan.']);
    }

}


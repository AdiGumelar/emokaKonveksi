<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('loginPage');
    }

    public function login(Request $request)
    {
        $email = $request->input('email_give');
        $password = $request->input('pw_give');

        // Autentikasi admin dummy 
        if ($email === 'admin@emoka.com' && $password === 'admin123') {
            session(['admin' => true]);
            return response()->json(['result' => 'dashboard']);
        }

        $user = User::where('email', $email)->first();
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            return response()->json(['result' => 'success']);
        } else {
            return response()->json(['result' => 'error', 'msg' => 'Email atau password salah.']);
        }
    }

    public function showRegister()
    {
        return view('regisPage');
    }

    public function register(Request $request)
    {
        $username = $request->input('username_give');
        $email = $request->input('email_give');
        $password = $request->input('pw_give');

        // Cek apakah username atau email sudah digunakan
        if (User::where('username', $username)->exists()) {
            return response()->json(['result' => 'error', 'msg' => 'Username sudah digunakan!']);
        }

        if (User::where('email', $email)->exists()) {
            return response()->json(['result' => 'error', 'msg' => 'Email sudah digunakan!']);
        }

        // Simpan user
        $user = User::create([
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $profile = $user->profile()->create([
            'nama' => '',
            'nomor' => '',
            'alamat' => '',
            'foto' => null
        ]);

        
        return response()->json(['result' => 'success', 'msg' => 'Registrasi berhasil!']);
    }
}

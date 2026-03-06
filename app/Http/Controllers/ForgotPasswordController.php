<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    protected $tokens = [];

    public function showForm()
    {
        return view('lupaPassword');
    }

    public function handleRequest(Request $request)
    {
        $email = $request->input('email');
        $token = $request->input('token');
        $newPassword = $request->input('new_password');

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Email tidak ditemukan.']);
        }

        if ($token && $newPassword) {
            if (Session::get("reset_token_$email") !== $token) {
                return response()->json(['success' => false, 'message' => 'Token tidak valid.']);
            }

            $user->password = Hash::make($newPassword);
            $user->save();
            Session::forget("reset_token_$email");
            return response()->json(['success' => true, 'message' => 'Password berhasil direset.']);
        }

        // generate token dan kirim email
        $genToken = strtoupper(Str::random(6));
        Session::put("reset_token_$email", $genToken);

        // Ganti dengan email konfigurasi Laravelmu
        Mail::raw("Berikut adalah token reset password Anda:\n\n$genToken", function ($message) use ($email) {
            $message->to($email)
                ->subject("Reset Password - Emoka Konveksi");
        });

        return response()->json(['token_sent' => true, 'message' => 'Token telah dikirim ke email Anda.']);
    }
}


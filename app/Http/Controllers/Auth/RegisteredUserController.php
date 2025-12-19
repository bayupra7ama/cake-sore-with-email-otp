<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Otp;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Buat user (BELUM AKTIF)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'is_active' => false,
        ]);

        // Login sementara (untuk OTP)
        Auth::login($user);

        // Hapus OTP lama (jika ada)
        Otp::where('user_id', $user->id)->delete();

        // Generate OTP
        $code = rand(100000, 999999);

        Otp::create([
            'user_id' => $user->id,
            'code' => $code,
            'expired_at' => now()->addMinutes(5),
        ]);

        // Kirim OTP ke email
        Mail::to($user->email)->send(new OtpMail($code));

        // Redirect ke halaman OTP
        return redirect()->route('otp.form')
            ->with('success', 'Kode OTP telah dikirim ke email Anda');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;

class OtpController extends Controller
{
    public function show()
    {
        return view('auth.otp');
    }

    // 🔥 KIRIM OTP SAAT BUTTON DIKLIK
    public function send()
    {
        // batasi kirim OTP tiap 1 menit
        $lastOtp = Otp::where('user_id', auth()->id())
            ->where('created_at', '>', now()->subMinute())
            ->first();

        if ($lastOtp) {
            return back()->withErrors([
                'otp' => 'Tunggu 1 menit sebelum kirim OTP lagi'
            ]);
        }

        Otp::where('user_id', auth()->id())->delete();

        $code = rand(100000, 999999);

        Otp::create([
            'user_id' => auth()->id(),
            'code' => $code,
            'expired_at' => now()->addMinutes(5),
        ]);

        Mail::to(auth()->user()->email)->send(new OtpMail($code));

        return back()->with('success', 'Kode OTP dikirim');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $otp = Otp::where('user_id', auth()->id())
            ->where('code', $request->otp)
            ->where('is_used', false)
            ->where('expired_at', '>', now())
            ->first();

        if (!$otp) {
            return back()->withErrors([
                'otp' => 'OTP tidak valid atau kadaluarsa'
            ]);
        }

        $otp->update(['is_used' => true]);

        // 🔐 OTP SESSION
        session(['otp_verified' => true]);

        // 🔐 AKTIFKAN AKUN JIKA BELUM (REGISTRASI)
        if (!auth()->user()->is_active) {
            auth()->user()->update(['is_active' => true]);
        }

        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
}


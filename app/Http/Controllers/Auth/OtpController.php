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
                'otp' => 'OTP tidak valid atau sudah kadaluarsa'
            ]);
        }

        // Tandai OTP terpakai
        $otp->update(['is_used' => true]);

        // Aktifkan akun
        auth()->user()->update([
            'is_active' => true
        ]);

        // Tandai OTP sudah diverifikasi
        session(['otp_verified' => true]);

        // Redirect sesuai role
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    }

}

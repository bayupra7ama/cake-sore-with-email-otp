<?php

namespace App\Http\Controllers\Auth;

use App\Models\Otp;
use App\Mail\OtpMail;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        // ❌ BLOK JIKA AKUN BELUM AKTIF
        if (!auth()->user()->is_active) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun belum diverifikasi OTP'
            ]);
        }

        // Hapus OTP lama
        Otp::where('user_id', auth()->id())->delete();

        // Generate OTP baru
        $code = rand(100000, 999999);

        Otp::create([
            'user_id' => auth()->id(),
            'code' => $code,
            'expired_at' => now()->addMinutes(5),
        ]);

        // Kirim OTP
        Mail::to(auth()->user()->email)->send(new OtpMail($code));

        // Redirect ke form OTP
        return redirect()->route('otp.form');
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

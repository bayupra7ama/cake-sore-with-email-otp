@if (session('success'))
    <p class="text-green-600">{{ session('success') }}</p>
@endif

<form method="POST" action="{{ route('otp.send') }}">
    @csrf
    <button type="submit">
        Kirim Kode OTP
    </button>
</form>

<form method="POST" action="{{ route('otp.verify') }}">
    @csrf
    <input type="text" name="otp" placeholder="Masukkan OTP">
    <button type="submit">Verifikasi</button>
</form>

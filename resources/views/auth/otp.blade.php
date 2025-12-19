<form method="POST" action="{{ route('otp.verify') }}">
    @csrf
    <label>Kode OTP</label>
    <input type="text" name="otp">
    <button type="submit">Verifikasi</button>
</form>

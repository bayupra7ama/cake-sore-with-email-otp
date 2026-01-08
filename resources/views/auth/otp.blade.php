<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Verifikasi OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #f4f6f8;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .otp-card {
            background: #fff;
            width: 100%;
            max-width: 420px;
            padding: 28px;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .1);
        }

        .otp-title {
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .otp-desc {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-bottom: 24px;
        }

        .otp-inputs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .otp-inputs input {
            width: 48px;
            height: 56px;
            font-size: 22px;
            text-align: center;
            border-radius: 8px;
            border: 1.5px solid #ccc;
            outline: none;
        }

        .btn-primary {
            width: 100%;
            background: #71997e;
            color: #fff;
            border: none;
            padding: 14px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
        }

        .countdown {
            margin-top: 16px;
            text-align: center;
            font-size: 13px;
            color: #666;
            display: none;
        }

        .resend-btn {
            margin-top: 10px;
            text-align: center;
        }

        .resend-btn button {
            background: none;
            border: none;
            font-size: 13px;
            color: #2563eb;
            cursor: pointer;
        }

        .resend-btn button.disabled {
            color: #999;
            cursor: not-allowed;
        }

        /* ================= MOBILE RESPONSIVE FIX ================= */
        @media (max-width: 480px) {

            body {
                padding: 16px;
            }

            .otp-card {
                padding: 20px 16px;
                border-radius: 10px;
            }

            .otp-title {
                font-size: 20px;
            }

            .otp-desc {
                font-size: 13px;
                margin-bottom: 18px;
            }

            .otp-inputs {
                gap: 6px;
                margin-bottom: 20px;
            }

            .otp-inputs input {
                width: 42px;
                height: 48px;
                font-size: 18px;
                border-radius: 6px;
            }

            .btn-primary {
                padding: 12px;
                font-size: 14px;
            }

            .countdown {
                font-size: 12px;
            }

            .resend-btn button {
                font-size: 12px;
            }
        }

        /* EXTRA SMALL DEVICE (HP MINI) */
        @media (max-width: 360px) {
            .otp-inputs input {
                width: 38px;
                height: 46px;
                font-size: 17px;
            }
        }
    </style>
</head>

<body>

    <div class="otp-card">

        <div class="otp-title">Verifikasi OTP</div>
        <div class="otp-desc">Masukkan 6 digit kode OTP</div>

        <form method="POST" action="{{ route('otp.verify') }}" id="otpForm">
            @csrf
            <input type="hidden" name="otp" id="otpValue">

            <div class="otp-inputs">
                @for ($i = 0; $i < 6; $i++)
                    <input type="text" maxlength="1" inputmode="numeric">
                @endfor
            </div>

            <button class="btn-primary">Verifikasi</button>
        </form>

        <div class="countdown" id="countdownBox">
            Kirim ulang OTP dalam <strong id="countdown">02:00</strong>
        </div>

        <div class="resend-btn">
            <form method="POST" action="{{ route('otp.send') }}" id="resendForm">
                @csrf
                <button type="submit" id="resendBtn">Kirim OTP</button>
            </form>
        </div>

    </div>

    <script>
        /* ================= OTP INPUT ================= */
        const inputs = document.querySelectorAll('.otp-inputs input');
        const otpHidden = document.getElementById('otpValue');

        inputs[0].focus();

        inputs.forEach((input, i) => {
            input.addEventListener('input', () => {
                input.value = input.value.replace(/[^0-9]/g, '');
                if (input.value && i < inputs.length - 1) {
                    inputs[i + 1].focus();
                }
                otpHidden.value = [...inputs].map(i => i.value).join('');
            });

            input.addEventListener('keydown', e => {
                if (e.key === 'Backspace' && !input.value && i > 0) {
                    inputs[i - 1].focus();
                }
            });
        });

        /* ================= COUNTDOWN LOGIC ================= */
        const countdownBox = document.getElementById('countdownBox');
        const countdownEl = document.getElementById('countdown');
        const resendBtn = document.getElementById('resendBtn');

        const DURATION = 120; // 2 menit
        let timer = null;

        function startCountdown(endTime) {
            countdownBox.style.display = 'block';
            resendBtn.classList.add('disabled');
            resendBtn.disabled = true;

            timer = setInterval(() => {
                const now = Math.floor(Date.now() / 1000);
                let remaining = endTime - now;

                if (remaining <= 0) {
                    clearInterval(timer);
                    localStorage.removeItem('otp_end_time');

                    countdownBox.style.display = 'none';
                    resendBtn.disabled = false;
                    resendBtn.classList.remove('disabled');
                    resendBtn.textContent = 'Kirim ulang OTP';
                    return;
                }

                let m = String(Math.floor(remaining / 60)).padStart(2, '0');
                let s = String(remaining % 60).padStart(2, '0');
                countdownEl.textContent = `${m}:${s}`;
            }, 1000);
        }

        /* ================= FIRST LOAD ================= */
        const savedEndTime = localStorage.getItem('otp_end_time');

        if (savedEndTime) {
            startCountdown(parseInt(savedEndTime));
        }

        /* ================= SEND OTP ================= */
        document.getElementById('resendForm').addEventListener('submit', () => {
            const endTime = Math.floor(Date.now() / 1000) + DURATION;
            localStorage.setItem('otp_end_time', endTime);
        });
    </script>

</body>

</html>

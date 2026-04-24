<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email — Tunara</title>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500&family=Geist:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Geist', sans-serif; background: #030305; color: #f0f0ff; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .bg-orb { position: fixed; border-radius: 50%; filter: blur(100px); pointer-events: none; }
        .orb-1 { width: 500px; height: 500px; background: radial-gradient(circle, rgba(91,127,255,0.08), transparent 70%); top: -100px; right: -100px; }
        .orb-2 { width: 400px; height: 400px; background: radial-gradient(circle, rgba(167,139,250,0.06), transparent 70%); bottom: -100px; left: -100px; }
        .card { position: relative; z-index: 1; background: #080810; border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; padding: 44px 40px; max-width: 440px; width: 100%; text-align: center; overflow: hidden; }
        .card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, #5b7fff, #a78bfa, transparent); }
        .logo { display: flex; align-items: center; justify-content: center; gap: 7px; margin-bottom: 32px; }
        .logo-dot { width: 6px; height: 6px; border-radius: 50%; background: #10d98a; animation: pulse 2s infinite; }
        .logo-text { font-size: 16px; font-weight: 700; color: #f0f0ff; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }
        .icon { width: 64px; height: 64px; border-radius: 18px; background: linear-gradient(135deg, #5b7fff, #a78bfa); display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 28px; box-shadow: 0 16px 48px rgba(91,127,255,0.25); }
        h1 { font-size: 22px; font-weight: 700; letter-spacing: -0.02em; margin-bottom: 8px; }
        .sub { font-size: 13px; color: #7878a0; line-height: 1.65; margin-bottom: 8px; }
        .email-badge { display: inline-flex; align-items: center; gap: 6px; background: rgba(91,127,255,0.08); border: 1px solid rgba(91,127,255,0.2); border-radius: 20px; padding: 4px 14px; font-size: 12px; color: #5b7fff; font-family: 'JetBrains Mono', monospace; margin-bottom: 28px; }
        .otp-wrap { display: flex; gap: 10px; justify-content: center; margin-bottom: 8px; }
        .otp-input { width: 52px; height: 58px; background: #0d0d18; border: 1.5px solid rgba(255,255,255,0.08); border-radius: 10px; color: #f0f0ff; font-size: 24px; font-weight: 700; text-align: center; font-family: 'JetBrains Mono', monospace; outline: none; transition: all 0.2s; }
        .otp-input:focus { border-color: #5b7fff; box-shadow: 0 0 0 3px rgba(91,127,255,0.15); }
        .otp-input.filled { border-color: rgba(91,127,255,0.4); background: rgba(91,127,255,0.05); }
        .error { background: rgba(255,77,106,0.08); border: 1px solid rgba(255,77,106,0.2); border-radius: 8px; padding: 10px 14px; font-size: 12px; color: #ff4d6a; margin-bottom: 16px; text-align: left; }
        .success-msg { background: rgba(16,217,138,0.08); border: 1px solid rgba(16,217,138,0.2); border-radius: 8px; padding: 10px 14px; font-size: 12px; color: #10d98a; margin-bottom: 16px; }
        .btn { width: 100%; padding: 13px; background: linear-gradient(135deg, #5b7fff, #a78bfa); color: white; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'Geist', sans-serif; transition: all 0.2s; margin-bottom: 16px; }
        .btn:hover { opacity: 0.88; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(91,127,255,0.3); }
        .btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
        .resend-wrap { display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 13px; color: #7878a0; }
        .resend-btn { background: none; border: none; color: #5b7fff; font-size: 13px; cursor: pointer; font-family: 'Geist', sans-serif; padding: 0; transition: opacity 0.15s; }
        .resend-btn:hover { opacity: 0.75; }
        .timer { font-family: 'JetBrains Mono', monospace; font-size: 12px; color: #3a3a58; margin-top: 20px; }
    </style>
</head>
<body>
<div class="bg-orb orb-1"></div>
<div class="bg-orb orb-2"></div>

<div class="card">
    <div class="logo">
        <div class="logo-dot"></div>
        <span class="logo-text">Tunara</span>
    </div>

    <div class="icon">✉️</div>
    <h1>Check your email</h1>
    <p class="sub">We sent a 6-digit verification code to</p>
    <div class="email-badge">
        ✉ {{ session('pending_user.email') }}
    </div>

    @if($errors->any())
    <div class="error">{{ $errors->first() }}</div>
    @endif

    @if(session('resent'))
    <div class="success-msg">✓ {{ session('resent') }}</div>
    @endif

    <form method="POST" action="{{ route('otp.verify.submit') }}" id="otp-form">
        @csrf
        <div class="otp-wrap">
            @for($i = 1; $i <= 6; $i++)
            <input type="text" maxlength="1" class="otp-input" id="otp-{{ $i }}" data-index="{{ $i }}" inputmode="numeric" autocomplete="off">
            @endfor
        </div>
        <input type="hidden" name="otp" id="otp-hidden">
        <p style="font-size:11px;color:#3a3a58;margin-bottom:20px;">Enter the 6-digit code from your email</p>

        <button type="submit" class="btn" id="verify-btn" disabled>Verify Email</button>
    </form>

    <div class="resend-wrap">
        <span>Didn't receive it?</span>
        <form method="POST" action="{{ route('otp.resend') }}" style="display:inline;">
            @csrf
            <button type="submit" class="resend-btn">Resend code</button>
        </form>
    </div>

    <div class="timer" id="timer">Code expires in <span id="countdown">10:00</span></div>
</div>

<script>
// OTP inputs auto-focus
const inputs = document.querySelectorAll('.otp-input');
const hidden = document.getElementById('otp-hidden');
const btn    = document.getElementById('verify-btn');

inputs.forEach((inp, i) => {
    inp.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
        if (this.value && i < inputs.length - 1) {
            inputs[i + 1].focus();
        }
        if (this.value) this.classList.add('filled');
        else this.classList.remove('filled');
        updateHidden();
    });

    inp.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && !this.value && i > 0) {
            inputs[i - 1].focus();
            inputs[i - 1].classList.remove('filled');
        }
    });

    inp.addEventListener('paste', function(e) {
        e.preventDefault();
        const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
        paste.split('').forEach((char, idx) => {
            if (inputs[idx]) {
                inputs[idx].value = char;
                inputs[idx].classList.add('filled');
            }
        });
        updateHidden();
        if (paste.length === 6) inputs[5].focus();
    });
});

function updateHidden() {
    const otp = Array.from(inputs).map(i => i.value).join('');
    hidden.value = otp;
    btn.disabled = otp.length !== 6;
}

// Countdown timer
let seconds = 600;
const countdown = document.getElementById('countdown');
const timer = setInterval(() => {
    seconds--;
    const m = Math.floor(seconds / 60).toString().padStart(2, '0');
    const s = (seconds % 60).toString().padStart(2, '0');
    countdown.textContent = `${m}:${s}`;
    if (seconds <= 0) {
        clearInterval(timer);
        countdown.textContent = 'expired';
        btn.disabled = true;
    }
}, 1000);

inputs[0].focus();
</script>
</body>
</html>

@extends('layouts.app')
@section('title', 'Create Account — Tunara')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600&family=Geist:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    * { font-family: 'Geist', sans-serif !important; }
    code, .mono { font-family: 'JetBrains Mono', monospace !important; }

    body {
        display: flex;
        min-height: 100vh;
        background: #030305;
        cursor: none;
    }

    .cursor { width: 8px; height: 8px; background: #5b7fff; border-radius: 50%; position: fixed; pointer-events: none; z-index: 9999; transition: transform 0.1s ease; mix-blend-mode: screen; }
    .cursor-ring { width: 32px; height: 32px; border: 1px solid rgba(91,127,255,0.4); border-radius: 50%; position: fixed; pointer-events: none; z-index: 9998; transition: all 0.15s ease; }

    .dot-grid { position: fixed; inset: 0; z-index: 0; pointer-events: none; background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px); background-size: 28px 28px; mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%); }
    .orb { position: fixed; border-radius: 50%; filter: blur(100px); pointer-events: none; z-index: 0; }
    .orb-1 { width: 500px; height: 500px; background: radial-gradient(circle, rgba(167,139,250,0.07) 0%, transparent 70%); top: -150px; right: -100px; }
    .orb-2 { width: 350px; height: 350px; background: radial-gradient(circle, rgba(91,127,255,0.05) 0%, transparent 70%); bottom: -100px; left: -100px; }

    .auth-left {
        width: 44%;
        border-right: 1px solid rgba(255,255,255,0.05);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 40px;
        position: relative;
        z-index: 1;
        overflow: hidden;
        background: linear-gradient(145deg, rgba(13,18,40,0.9) 0%, rgba(8,8,16,0.9) 100%);
    }
    .auth-left::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(167,139,250,0.3), transparent);
    }

    .auth-logo {
        font-size: 16px;
        font-weight: 700;
        color: #f0f0ff;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        position: relative;
        z-index: 1;
        width: fit-content;
    }
    .auth-logo-dot { width: 6px; height: 6px; border-radius: 50%; background: #10d98a; animation: pulse 2s infinite; }
    @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.5;transform:scale(0.8)} }

    .auth-left-content { position: relative; z-index: 1; }
    .auth-left-content h2 { font-size: 28px; font-weight: 700; letter-spacing: -0.03em; line-height: 1.2; margin-bottom: 14px; color: #f0f0ff; }
    .auth-left-content p { font-size: 14px; color: #7878a0; line-height: 1.7; margin-bottom: 28px; }

    .perks { display: flex; flex-direction: column; gap: 10px; }
    .perk {
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 8px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: #7878a0;
    }
    .perk-icon { font-size: 16px; }

    .auth-left-footer { font-size: 11px; color: #3a3a58; position: relative; z-index: 1; font-family: 'JetBrains Mono', monospace !important; }

    .auth-right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        background: #030305;
        position: relative;
        z-index: 1;
        overflow-y: auto;
    }

    .auth-form-wrap { width: 100%; max-width: 360px; }
    .auth-form-wrap h1 { font-size: 24px; font-weight: 700; letter-spacing: -0.03em; margin-bottom: 6px; color: #f0f0ff; }
    .auth-form-wrap > p { font-size: 13px; color: #7878a0; margin-bottom: 28px; }

    .auth-form { display: flex; flex-direction: column; gap: 14px; }

    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group label { font-size: 12px; font-weight: 500; color: #7878a0; letter-spacing: 0.02em; }
    .input {
        background: #080810;
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 13px;
        color: #f0f0ff;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: 'Geist', sans-serif !important;
        width: 100%;
    }
    .input:focus { border-color: #5b7fff; box-shadow: 0 0 0 3px rgba(91,127,255,0.1); }
    .input::placeholder { color: #3a3a58; }
    .input.error { border-color: rgba(255,77,106,0.4); }

    .pw-hint {
        font-size: 11px;
        color: #3a3a58;
        font-family: 'JetBrains Mono', monospace !important;
        margin-top: 4px;
    }
    .pw-strength { display: flex; gap: 4px; margin-top: 6px; }
    .pw-bar { height: 3px; flex: 1; border-radius: 2px; background: rgba(255,255,255,0.06); transition: background 0.3s; }
    .pw-bar.weak { background: #ff4d6a; }
    .pw-bar.ok { background: #fbbf24; }
    .pw-bar.strong { background: #10d98a; }

    .auth-submit {
        width: 100%;
        padding: 11px;
        font-size: 14px;
        font-weight: 600;
        background: #5b7fff;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: none;
        transition: all 0.2s;
        position: relative;
        overflow: hidden;
        margin-top: 4px;
        font-family: 'Geist', sans-serif !important;
    }
    .auth-submit::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent); opacity: 0; transition: opacity 0.2s; }
    .auth-submit:hover::before { opacity: 1; }
    .auth-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(91,127,255,0.35); }

    .auth-footer-text { text-align: center; font-size: 12px; color: #3a3a58; margin-top: 20px; }
    .auth-footer-text a { color: #5b7fff; transition: opacity 0.15s; }
    .auth-footer-text a:hover { opacity: 0.8; }

    .error-box { background: rgba(255,77,106,0.08); border: 1px solid rgba(255,77,106,0.2); border-radius: 8px; padding: 12px 14px; margin-bottom: 16px; }
    .error-box p { font-size: 12.5px; color: #ff4d6a; }

    .mobile-logo { display: none; font-size: 16px; font-weight: 700; color: #f0f0ff; margin-bottom: 24px; align-items: center; gap: 8px; text-decoration: none; }
    .mobile-logo-dot { width: 6px; height: 6px; border-radius: 50%; background: #10d98a; }

    @media (max-width: 768px) {
        body { cursor: auto; }
        .cursor, .cursor-ring { display: none; }
        .auth-left { display: none; }
        .mobile-logo { display: flex; }
    }
</style>
@endsection

@section('content')
<div class="cursor" id="cursor"></div>
<div class="cursor-ring" id="cursorRing"></div>
<div class="dot-grid"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="auth-left">
    <a href="{{ route('home') }}" class="auth-logo">
        <div class="auth-logo-dot"></div>
        Tunara
    </a>
    <div class="auth-left-content">
        <h2>Start sharing your work in minutes</h2>
        <p>Create your free account and get a public URL for your local project instantly.</p>
        <div class="perks">
            <div class="perk"><span class="perk-icon">🚀</span> Free to get started — no credit card</div>
            <div class="perk"><span class="perk-icon">⚡</span> Up and running in under 2 minutes</div>
            <div class="perk"><span class="perk-icon">🔒</span> Secure tunnels with auth tokens</div>
            <div class="perk"><span class="perk-icon">🌍</span> Share with anyone, anywhere</div>
        </div>
    </div>
    <span class="auth-left-footer">© {{ date('Y') }} Tunara</span>
</div>

<div class="auth-right">
    <div class="auth-form-wrap">
        <a href="{{ route('home') }}" class="mobile-logo">
            <div class="mobile-logo-dot"></div>
            Tunara
        </a>
        <h1>Create your account</h1>
        <p>Start sharing your local projects for free</p>

        @if($errors->any())
        <div class="error-box">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf
            <div class="form-group">
                <label for="name">Full name</label>
                <input class="input" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input class="input" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input class="input" type="password" id="password" name="password" placeholder="Min. 8 characters" required minlength="8" oninput="checkStrength(this.value)">
                <div class="pw-strength">
                    <div class="pw-bar" id="bar1"></div>
                    <div class="pw-bar" id="bar2"></div>
                    <div class="pw-bar" id="bar3"></div>
                    <div class="pw-bar" id="bar4"></div>
                </div>
                <span class="pw-hint" id="pw-hint">Minimum 8 characters</span>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm password</label>
                <input class="input" type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat your password" required minlength="8">
            </div>
            <button type="submit" class="auth-submit">Create account</button>
        </form>

        <p class="auth-footer-text">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </p>
    </div>
</div>

<script>
const cursor = document.getElementById('cursor');
const ring = document.getElementById('cursorRing');
let mx=0,my=0,rx=0,ry=0;
document.addEventListener('mousemove',e=>{mx=e.clientX;my=e.clientY;cursor.style.left=mx-4+'px';cursor.style.top=my-4+'px'});
function animRing(){rx+=(mx-rx)*0.12;ry+=(my-ry)*0.12;ring.style.left=rx-16+'px';ring.style.top=ry-16+'px';requestAnimationFrame(animRing)}
animRing();
document.querySelectorAll('a,button,input').forEach(el=>{
    el.addEventListener('mouseenter',()=>{cursor.style.transform='scale(2)';ring.style.borderColor='rgba(91,127,255,0.6)'});
    el.addEventListener('mouseleave',()=>{cursor.style.transform='scale(1)';ring.style.borderColor='rgba(91,127,255,0.4)'});
});

function checkStrength(val) {
    const bars = [document.getElementById('bar1'),document.getElementById('bar2'),document.getElementById('bar3'),document.getElementById('bar4')];
    const hint = document.getElementById('pw-hint');
    bars.forEach(b => { b.className = 'pw-bar'; });

    let score = 0;
    if (val.length >= 8) score++;
    if (val.length >= 12) score++;
    if (/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const labels = ['Too short', 'Weak', 'Fair', 'Strong'];
    const classes = ['weak', 'weak', 'ok', 'strong'];

    if (val.length === 0) { hint.textContent = 'Minimum 8 characters'; return; }
    if (val.length < 8) { bars[0].classList.add('weak'); hint.textContent = 'Too short — min 8 characters'; return; }

    for (let i = 0; i < score; i++) bars[i].classList.add(classes[score - 1]);
    hint.textContent = labels[score - 1] || 'Strong password';
}
</script>
@endsection

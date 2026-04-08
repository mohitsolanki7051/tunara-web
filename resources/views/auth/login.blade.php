@extends('layouts.app')
@section('title', 'Login — Tunara')

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
    .orb-1 { width: 500px; height: 500px; background: radial-gradient(circle, rgba(91,127,255,0.07) 0%, transparent 70%); top: -150px; left: -100px; }
    .orb-2 { width: 350px; height: 350px; background: radial-gradient(circle, rgba(167,139,250,0.05) 0%, transparent 70%); bottom: -100px; right: -100px; }

    /* LEFT PANEL */
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
        background: linear-gradient(90deg, transparent, rgba(91,127,255,0.3), transparent);
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
    .auth-left-content h2 {
        font-size: 28px;
        font-weight: 700;
        letter-spacing: -0.03em;
        line-height: 1.2;
        margin-bottom: 14px;
        color: #f0f0ff;
    }
    .auth-left-content p { font-size: 14px; color: #7878a0; line-height: 1.7; margin-bottom: 32px; }

    .auth-features { display: flex; flex-direction: column; gap: 10px; }
    .auth-feature {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: #7878a0;
        padding: 10px 14px;
        background: rgba(255,255,255,0.02);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 8px;
    }
    .auth-feature-icon { font-size: 15px; }

    .auth-left-footer { font-size: 11px; color: #3a3a58; position: relative; z-index: 1; font-family: 'JetBrains Mono', monospace !important; }

    /* RIGHT PANEL */
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

    .auth-form { display: flex; flex-direction: column; gap: 16px; }

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

    .remember-row { display: flex; align-items: center; gap: 8px; }
    .remember-row input[type="checkbox"] { width: 14px; height: 14px; accent-color: #5b7fff; cursor: none; }
    .remember-row label { margin-top: 5px; font-size: 12px; color: #7878a0; cursor: none; }

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
        font-family: 'Geist', sans-serif !important;
    }
    .auth-submit::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent); opacity: 0; transition: opacity 0.2s; }
    .auth-submit:hover::before { opacity: 1; }
    .auth-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(91,127,255,0.35); }

    .auth-footer-text { text-align: center; font-size: 12px; color: #3a3a58; margin-top: 20px; }
    .auth-footer-text a { color: #5b7fff; transition: opacity 0.15s; }
    .auth-footer-text a:hover { opacity: 0.8; }

    .error-box { background: rgba(255,77,106,0.08); border: 1px solid rgba(255,77,106,0.2); border-radius: 8px; padding: 12px 14px; margin-bottom: 18px; }
    .error-box p { font-size: 12.5px; color: #ff4d6a; }

    .mobile-logo { display: none; font-size: 16px; font-weight: 700; color: #f0f0ff; margin-bottom: 24px; display: flex; align-items: center; gap: 8px; text-decoration: none; }
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
        <h2>Share your local project with the world</h2>
        <p>Expose your dev server to the internet in seconds. No complex setup, no terminal commands.</p>
        <div class="auth-features">
            <div class="auth-feature"><span class="auth-feature-icon">⚡</span> No CLI required — just click and go</div>
            <div class="auth-feature"><span class="auth-feature-icon">🔒</span> Secure token-based authentication</div>
            <div class="auth-feature"><span class="auth-feature-icon">🌍</span> Works with any framework or language</div>
            <div class="auth-feature"><span class="auth-feature-icon">📊</span> Real-time request logs in desktop app</div>
        </div>
    </div>
    <span class="auth-left-footer">© {{ date('Y') }} Tunara</span>
</div>

<div class="auth-right">
    <div class="auth-form-wrap">
        {{-- <a href="{{ route('home') }}" class="mobile-logo">
            <div class="mobile-logo-dot"></div>
            Tunara
        </a> --}}
        <h1>Welcome back</h1>
        <p>Sign in to your Tunara account</p>

        @if($errors->any())
        <div class="error-box">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf
            <div class="form-group">
                <label for="email">Email address</label>
                <input class="input" type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input class="input" type="password" id="password" name="password" placeholder="••••••••" required minlength="8">
            </div>
            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me for 30 days</label>
            </div>
            <button type="submit" class="auth-submit">Sign in</button>
        </form>

        <p class="auth-footer-text">
            Don't have an account? <a href="{{ route('register') }}">Sign up for free</a>
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
</script>
@endsection

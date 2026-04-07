@extends('layouts.app')
@section('title', 'Login — Tunara')

@section('head')
<style>
    body { display: flex; min-height: 100vh; }

    .auth-left {
        width: 44%;
        background: linear-gradient(145deg, #0d1228 0%, #111827 50%, #0d1228 100%);
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 40px;
        position: relative;
        overflow: hidden;
    }
    .auth-left::before {
        content: '';
        position: absolute;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(91,127,255,0.12) 0%, transparent 70%);
        top: -100px; left: -100px;
        pointer-events: none;
    }
    .auth-left::after {
        content: '';
        position: absolute;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(167,139,250,0.08) 0%, transparent 70%);
        bottom: -50px; right: -50px;
        pointer-events: none;
    }

    .auth-logo { font-size: 22px; font-weight: 700; background: linear-gradient(135deg, var(--accent), var(--accent-2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; position: relative; z-index: 1; }

    .auth-left-content { position: relative; z-index: 1; }
    .auth-left-content h2 { font-size: 32px; font-weight: 700; letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 16px; }
    .auth-left-content p { font-size: 15px; color: var(--text-2); line-height: 1.7; margin-bottom: 32px; }
    .auth-features { display: flex; flex-direction: column; gap: 12px; }
    .auth-feature { display: flex; align-items: center; gap: 10px; font-size: 14px; color: var(--text-2); }
    .auth-feature-dot { width: 6px; height: 6px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), var(--accent-2)); flex-shrink: 0; }

    .auth-left-footer { font-size: 12px; color: var(--text-3); position: relative; z-index: 1; }

    .auth-right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        background: var(--bg);
    }

    .auth-form-wrap { width: 100%; max-width: 380px; }
    .auth-form-wrap h1 { font-size: 26px; font-weight: 700; letter-spacing: -0.02em; margin-bottom: 6px; }
    .auth-form-wrap > p { font-size: 14px; color: var(--text-2); margin-bottom: 28px; }

    .auth-form { display: flex; flex-direction: column; gap: 18px; }

    .remember-row { display: flex; align-items: center; gap: 8px; }
    .remember-row input[type="checkbox"] { width: 15px; height: 15px; accent-color: var(--accent); cursor: pointer; }
    .remember-row label { font-size: 13px; color: var(--text-2); margin-bottom: 0; cursor: pointer; }

    .auth-submit { width: 100%; padding: 12px; font-size: 14.5px; font-weight: 600; }

    .auth-footer-text { text-align: center; font-size: 13px; color: var(--text-3); margin-top: 24px; }
    .auth-footer-text a { color: var(--accent); transition: opacity 0.15s; }
    .auth-footer-text a:hover { opacity: 0.8; }

    .mobile-logo { display: none; font-size: 20px; font-weight: 700; background: linear-gradient(135deg, var(--accent), var(--accent-2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 28px; }

    @media (max-width: 768px) {
        .auth-left { display: none; }
        .mobile-logo { display: block; }
    }
</style>
@endsection

@section('content')
<div class="auth-left">
    <span class="auth-logo">Tunara</span>
    <div class="auth-left-content">
        <h2>Share your local<br>project with the world</h2>
        <p>Expose your development server to the internet in seconds. No complex setup, no terminal commands.</p>
        <div class="auth-features">
            <div class="auth-feature"><span class="auth-feature-dot"></span> No CLI required</div>
            <div class="auth-feature"><span class="auth-feature-dot"></span> Works with any framework</div>
            <div class="auth-feature"><span class="auth-feature-dot"></span> Secure & authenticated tunnels</div>
            <div class="auth-feature"><span class="auth-feature-dot"></span> Real-time request logs</div>
        </div>
    </div>
    <span class="auth-left-footer">© {{ date('Y') }} Tunara</span>
</div>

<div class="auth-right">
    <div class="auth-form-wrap">
        <a href="/" class="mobile-logo">Tunara</a>
        <h1>Welcome back</h1>
        <p>Sign in to your Tunara account</p>

        @if($errors->any())
        <div class="error-box" style="margin-bottom: 18px;">
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
                <input class="input" type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
            <div class="remember-row">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me for 30 days</label>
            </div>
            <button type="submit" class="btn btn-primary auth-submit">Sign in</button>
        </form>

        <p class="auth-footer-text">
            Don't have an account? <a href="{{ route('register') }}">Sign up for free</a>
        </p>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Create Account — Tunara')

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
        background: radial-gradient(circle, rgba(167,139,250,0.12) 0%, transparent 70%);
        top: -100px; right: -80px;
        pointer-events: none;
    }
    .auth-left::after {
        content: '';
        position: absolute;
        width: 280px; height: 280px;
        background: radial-gradient(circle, rgba(91,127,255,0.1) 0%, transparent 70%);
        bottom: 40px; left: -60px;
        pointer-events: none;
    }

    .auth-logo { font-size: 22px; font-weight: 700; background: linear-gradient(135deg, var(--accent), var(--accent-2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; position: relative; z-index: 1; }

    .auth-left-content { position: relative; z-index: 1; }
    .auth-left-content h2 { font-size: 30px; font-weight: 700; letter-spacing: -0.02em; line-height: 1.25; margin-bottom: 16px; }
    .auth-left-content p { font-size: 14px; color: var(--text-2); line-height: 1.7; margin-bottom: 28px; }

    .perks { display: flex; flex-direction: column; gap: 12px; }
    .perk {
        background: rgba(255,255,255,0.03);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13.5px;
        color: var(--text-2);
    }
    .perk-icon { font-size: 18px; }

    .auth-left-footer { font-size: 12px; color: var(--text-3); position: relative; z-index: 1; }

    .auth-right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        background: var(--bg);
        overflow-y: auto;
    }

    .auth-form-wrap { width: 100%; max-width: 380px; }
    .auth-form-wrap h1 { font-size: 26px; font-weight: 700; letter-spacing: -0.02em; margin-bottom: 6px; }
    .auth-form-wrap > p { font-size: 14px; color: var(--text-2); margin-bottom: 28px; }

    .auth-form { display: flex; flex-direction: column; gap: 16px; }
    .form-row { display: grid; gap: 14px; }
    .auth-submit { width: 100%; padding: 12px; font-size: 14.5px; font-weight: 600; margin-top: 4px; }

    .auth-footer-text { text-align: center; font-size: 13px; color: var(--text-3); margin-top: 24px; }
    .auth-footer-text a { color: var(--accent); }
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
        <h2>Start sharing your work in minutes</h2>
        <p>Create your free account and get a public URL for your local project instantly.</p>
        <div class="perks">
            <div class="perk"><span class="perk-icon">🚀</span> Free to get started, no credit card</div>
            <div class="perk"><span class="perk-icon">⚡</span> Up and running in under 2 minutes</div>
            <div class="perk"><span class="perk-icon">🔒</span> Secure tunnels with auth tokens</div>
        </div>
    </div>
    <span class="auth-left-footer">© {{ date('Y') }} Tunara</span>
</div>

<div class="auth-right">
    <div class="auth-form-wrap">
        <a href="/" class="mobile-logo">Tunara</a>
        <h1>Create your account</h1>
        <p>Start sharing your local projects for free</p>

        @if($errors->any())
        <div class="error-box" style="margin-bottom: 18px;">
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
                <input class="input" type="password" id="password" name="password" placeholder="Min. 8 characters" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm password</label>
                <input class="input" type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat your password" required>
            </div>
            <button type="submit" class="btn btn-primary auth-submit">Create account</button>
        </form>

        <p class="auth-footer-text">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </p>
    </div>
</div>
@endsection

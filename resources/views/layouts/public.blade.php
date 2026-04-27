<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <title>@yield('title', 'Tunara – Developer Tools Platform')</title>
    <meta name="description" content="@yield('meta-description', 'Tunara helps developers share local applications securely.')">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600;700&family=Geist:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #030305;
            --bg-2: #080810;
            --bg-3: #0d0d18;
            --bg-4: #12121f;
            --border: rgba(255,255,255,0.05);
            --border-2: rgba(255,255,255,0.1);
            --border-3: rgba(255,255,255,0.15);
            --text: #f0f0ff;
            --text-2: #7878a0;
            --text-3: #3a3a58;
            --accent: #5b7fff;
            --accent-2: #a78bfa;
            --accent-3: #22d3ee;
            --green: #10d98a;
            --red: #ff4d6a;
            --yellow: #fbbf24;
            --font: 'Geist', sans-serif;
            --mono: 'JetBrains Mono', monospace;
            --r: 12px;
            --r-lg: 20px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font); background: var(--bg); color: var(--text); -webkit-font-smoothing: antialiased; overflow-x: hidden; cursor: none; }
        a { color: inherit; text-decoration: none; }
        button { font-family: var(--font); cursor: none; border: none; background: none; }

        .cursor { width: 8px; height: 8px; background: var(--accent); border-radius: 50%; position: fixed; pointer-events: none; z-index: 9999; transition: transform 0.1s ease; mix-blend-mode: screen; }
        .cursor-ring { width: 32px; height: 32px; border: 1px solid rgba(91,127,255,0.4); border-radius: 50%; position: fixed; pointer-events: none; z-index: 9998; transition: all 0.15s ease; }

        .bg-mesh { position: fixed; inset: 0; z-index: 0; overflow: hidden; pointer-events: none; }
        .mesh-orb { position: absolute; border-radius: 50%; filter: blur(100px); animation: orbFloat 20s ease-in-out infinite; }
        .orb-1 { width: 700px; height: 700px; background: radial-gradient(circle, rgba(91,127,255,0.07) 0%, transparent 70%); top: -200px; right: -200px; }
        .orb-2 { width: 500px; height: 500px; background: radial-gradient(circle, rgba(34,211,238,0.05) 0%, transparent 70%); bottom: 100px; left: -150px; animation-delay: -7s; }
        @keyframes orbFloat { 0%,100%{transform:translate(0,0) scale(1)} 33%{transform:translate(30px,-40px) scale(1.05)} 66%{transform:translate(-20px,20px) scale(0.95)} }
        .dot-grid { position: fixed; inset: 0; z-index: 0; pointer-events: none; background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px); background-size: 28px 28px; mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%); }

        nav { position: fixed; top: 0; left: 0; right: 0; z-index: 100; padding: 0 48px; height: 56px; display: flex; align-items: center; justify-content: space-between; background: rgba(3,3,5,0.7); backdrop-filter: blur(24px) saturate(180%); border-bottom: 1px solid var(--border); }
        .nav-logo { font-family: var(--mono); font-size: 15px; font-weight: 600; color: var(--text); letter-spacing: -0.02em; display: flex; align-items: center; gap: 8px; }
        .nav-logo-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--green); animation: pulse 2s ease-in-out infinite; }
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.5;transform:scale(0.8)} }
        .nav-links { display: flex; align-items: center; gap: 4px; list-style: none; }
        .nav-links a { font-size: 13px; font-weight: 400; color: var(--text-2); padding: 6px 12px; border-radius: 6px; transition: color 0.2s, background 0.2s; }
        .nav-links a:hover { color: var(--text); background: rgba(255,255,255,0.04); }
        .nav-actions { display: flex; align-items: center; gap: 8px; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; font-family: var(--font); font-size: 13px; font-weight: 500; border-radius: 8px; transition: all 0.2s; cursor: none; border: none; white-space: nowrap; }
        .btn-ghost { background: transparent; color: var(--text-2); padding: 7px 14px; border: 1px solid var(--border-2); }
        .btn-ghost:hover { color: var(--text); border-color: var(--border-3); background: rgba(255,255,255,0.03); }
        .btn-primary { background: var(--accent); color: white; padding: 8px 18px; font-weight: 600; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(91,127,255,0.35); }

        footer { position: relative; z-index: 1; border-top: 1px solid var(--border); padding: 48px 48px 28px; }
        .footer-inner { max-width: 1160px; margin: 0 auto; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 60px; margin-bottom: 40px; }
        .footer-brand { font-family: var(--mono); font-size: 14px; font-weight: 600; margin-bottom: 10px; }
        .footer-brand-desc { font-size: 12px; color: var(--text-3); line-height: 1.7; max-width: 200px; }
        .footer-col-title { font-family: var(--mono); font-size: 10px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-3); margin-bottom: 12px; }
        .footer-links { display: flex; flex-direction: column; gap: 8px; }
        .footer-links a { font-size: 13px; color: var(--text-2); transition: color 0.15s; }
        .footer-links a:hover { color: var(--text); }
        .footer-bottom { padding-top: 20px; border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; font-family: var(--mono); font-size: 11px; color: var(--text-3); }

        @keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
        ::-webkit-scrollbar{width:3px} ::-webkit-scrollbar-track{background:transparent} ::-webkit-scrollbar-thumb{background:var(--bg-4)}

        /* Page content styles */
        .page-prose h1,.page-prose h2,.page-prose h3 { font-weight: 700; letter-spacing: -0.02em; margin-bottom: 12px; margin-top: 32px; color: var(--text); }
        .page-prose h1 { font-size: 28px; }
        .page-prose h2 { font-size: 20px; }
        .page-prose h3 { font-size: 16px; }
        .page-prose p { margin-bottom: 16px; }
        .page-prose ul,.page-prose ol { margin-bottom: 16px; padding-left: 20px; }
        .page-prose li { margin-bottom: 6px; }
        .page-prose a { color: var(--accent); }
        .page-prose strong { color: var(--text); font-weight: 600; }

        @media(max-width:768px) {
            body{cursor:auto} .cursor,.cursor-ring{display:none}
            nav{padding:0 20px} .nav-links{display:none}
            .footer-grid{grid-template-columns:1fr 1fr;gap:28px}
            footer{padding:40px 20px 24px}
        }

        @yield('styles')
    </style>
    @yield('head')
</head>
<body>

<div class="cursor" id="cursor"></div>
<div class="cursor-ring" id="cursorRing"></div>
<div class="bg-mesh"><div class="mesh-orb orb-1"></div><div class="mesh-orb orb-2"></div></div>
<div class="dot-grid"></div>

<nav>
    <a href="{{ route('home') }}" class="nav-logo">
        <div class="nav-logo-dot"></div>
        Tunara
    </a>
    <ul class="nav-links">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('home') }}#how-it-works">How it works</a></li>
        <li><a href="{{ route('home') }}#features">Features</a></li>
        <li><a href="{{ route('pricing') }}">Pricing</a></li>
        <li><a href="{{ route('download') }}">Download</a></li>
    </ul>
    <div class="nav-actions">
        @auth
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard →</a>
        @else
        <a href="{{ route('login') }}" class="btn btn-ghost">Sign in</a>
        <a href="{{ route('register') }}" class="btn btn-primary">Get started</a>
        @endauth
    </div>
</nav>

<div style="position:relative;z-index:1;">
    @yield('content')
</div>

<footer>
    <div class="footer-inner">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">tunara</div>
                <div class="footer-brand-desc">Simple, secure platform for sharing local applications.</div>
            </div>
            <div>
                <div class="footer-col-title">Product</div>
                <div class="footer-links">
                    <a href="{{ route('home') }}#how-it-works">How it works</a>
                    <a href="{{ route('pricing') }}">Pricing</a>
                    <a href="{{ route('download') }}">Download</a>
                </div>
            </div>
            <div>
                <div class="footer-col-title">Account</div>
                <div class="footer-links">
                    <a href="{{ route('login') }}">Sign in</a>
                    <a href="{{ route('register') }}">Sign up free</a>
                    @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    @endauth
                </div>
            </div>
            <div>
                <div class="footer-col-title">Company</div>
                <div class="footer-links">
                    <a href="{{ route('about') }}">About</a>
                    <a href="{{ route('contact') }}">Contact</a>
                    <a href="{{ route('privacy') }}">Privacy</a>
                    <a href="{{ route('terms') }}">Terms</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} tunara. all rights reserved.</span>
            <span>www.tunara.online</span>
            <span>made with ❤️ for developers</span>
        </div>
    </div>
</footer>

<script>
const cursor = document.getElementById('cursor');
const ring = document.getElementById('cursorRing');
let mx = 0, my = 0, rx = 0, ry = 0;
document.addEventListener('mousemove', e => {
    mx = e.clientX; my = e.clientY;
    cursor.style.left = mx - 4 + 'px';
    cursor.style.top = my - 4 + 'px';
});
function animRing() {
    rx += (mx - rx) * 0.12; ry += (my - ry) * 0.12;
    ring.style.left = rx - 16 + 'px'; ring.style.top = ry - 16 + 'px';
    requestAnimationFrame(animRing);
}
animRing();
document.querySelectorAll('a, button').forEach(el => {
    el.addEventListener('mouseenter', () => { cursor.style.transform='scale(2.5)'; ring.style.transform='scale(1.5)'; });
    el.addEventListener('mouseleave', () => { cursor.style.transform='scale(1)'; ring.style.transform='scale(1)'; });
});
</script>

@yield('scripts')
</body>
</html>

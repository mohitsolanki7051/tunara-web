<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download — Tunara</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:#050508;--bg-2:#0a0a10;--bg-3:#111118;--bg-4:#18181f;
            --border:rgba(255,255,255,0.06);--border-2:rgba(255,255,255,0.12);
            --text:#f0f0ff;--text-2:#8888aa;--text-3:#44445a;
            --accent:#6c63ff;--accent-2:#a78bfa;--accent-3:#38bdf8;
            --green:#22d3a0;--red:#ff5f7e;--yellow:#fbbf24;
            --font:'DM Sans',sans-serif;--display:'Syne',sans-serif;--mono:'DM Mono',monospace;
            --radius:16px;--radius-sm:10px;
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:var(--font);background:var(--bg);color:var(--text);-webkit-font-smoothing:antialiased;overflow-x:hidden}
        a{color:inherit;text-decoration:none}

        body::before{content:'';position:fixed;inset:0;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");pointer-events:none;z-index:1000;opacity:0.4}
        .grid-bg{position:fixed;inset:0;background-image:linear-gradient(rgba(108,99,255,0.03) 1px,transparent 1px),linear-gradient(90deg,rgba(108,99,255,0.03) 1px,transparent 1px);background-size:60px 60px;pointer-events:none;z-index:0}
        .orb{position:fixed;border-radius:50%;filter:blur(120px);pointer-events:none;z-index:0}
        .orb-1{width:500px;height:500px;background:rgba(108,99,255,0.08);top:-150px;right:-100px}

        nav{position:fixed;top:0;left:0;right:0;z-index:100;padding:0 40px;height:64px;display:flex;align-items:center;justify-content:space-between;background:rgba(5,5,8,0.85);backdrop-filter:blur(20px);border-bottom:1px solid var(--border)}
        .nav-logo{font-family:var(--display);font-size:22px;font-weight:800;background:linear-gradient(135deg,#fff 0%,var(--accent-2) 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .nav-links{display:flex;align-items:center;gap:28px;list-style:none}
        .nav-links a{font-size:14px;font-weight:500;color:var(--text-2);transition:color 0.2s}
        .nav-links a:hover,.nav-links a.active{color:var(--text)}
        .nav-actions{display:flex;align-items:center;gap:12px}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;font-family:var(--font);font-weight:500;border-radius:var(--radius-sm);transition:all 0.2s;cursor:pointer;border:none;font-size:14px}
        .btn-ghost{background:transparent;color:var(--text-2);padding:8px 18px;border:1px solid var(--border)}
        .btn-ghost:hover{border-color:var(--border-2);color:var(--text)}
        .btn-primary{background:linear-gradient(135deg,var(--accent),var(--accent-2));color:white;padding:10px 22px;font-weight:600;box-shadow:0 0 30px rgba(108,99,255,0.25)}
        .btn-primary:hover{opacity:0.9;transform:translateY(-1px)}

        .page-header{padding:140px 40px 60px;text-align:center;position:relative;z-index:1}
        .page-tag{display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;color:var(--accent);margin-bottom:16px}
        .page-tag::before{content:'';width:20px;height:1px;background:var(--accent)}
        .page-title{font-family:var(--display);font-size:clamp(40px,6vw,72px);font-weight:800;letter-spacing:-0.04em;line-height:1.05;margin-bottom:16px}
        .page-title .accent{background:linear-gradient(135deg,var(--accent),var(--accent-2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .page-sub{font-size:17px;color:var(--text-2);max-width:480px;margin:0 auto;line-height:1.65}

        .download-section{padding:40px 40px 80px;max-width:900px;margin:0 auto;position:relative;z-index:1}

        .download-hero{background:var(--bg-2);border:1px solid var(--border);border-radius:24px;padding:60px;text-align:center;position:relative;overflow:hidden;margin-bottom:32px}
        .download-hero::before{content:'';position:absolute;top:-80px;left:50%;transform:translateX(-50%);width:400px;height:400px;background:radial-gradient(circle,rgba(108,99,255,0.12),transparent 70%);pointer-events:none}
        .download-app-icon{width:90px;height:90px;border-radius:22px;background:linear-gradient(135deg,var(--accent),var(--accent-2));display:flex;align-items:center;justify-content:center;font-size:40px;margin:0 auto 24px;box-shadow:0 20px 60px rgba(108,99,255,0.35)}
        .download-app-name{font-family:var(--display);font-size:28px;font-weight:800;margin-bottom:6px}
        .download-version-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(34,211,160,0.1);border:1px solid rgba(34,211,160,0.2);color:var(--green);border-radius:100px;padding:4px 12px;font-size:12px;font-weight:600;margin-bottom:20px}
        .download-desc{font-size:15px;color:var(--text-2);max-width:440px;margin:0 auto 36px;line-height:1.65}

        .download-btns{display:flex;gap:16px;justify-content:center;flex-wrap:wrap;margin-bottom:20px}
        .download-btn{display:flex;align-items:center;gap:14px;background:var(--bg-3);border:2px solid var(--border-2);border-radius:14px;padding:16px 28px;transition:all 0.25s;min-width:190px}
        .download-btn:hover{border-color:var(--accent);transform:translateY(-3px);box-shadow:0 16px 48px rgba(108,99,255,0.2)}
        .download-btn.disabled{opacity:0.4;cursor:not-allowed}
        .download-btn.disabled:hover{transform:none;border-color:var(--border-2);box-shadow:none}
        .download-btn-icon{font-size:28px}
        .download-btn-label{font-size:11px;color:var(--text-3)}
        .download-btn-os{font-size:16px;font-weight:700}
        .download-meta{font-size:13px;color:var(--text-3)}

        .requirements-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:32px}
        .req-card{background:var(--bg-2);border:1px solid var(--border);border-radius:var(--radius);padding:24px}
        .req-title{font-family:var(--display);font-size:15px;font-weight:700;margin-bottom:14px;display:flex;align-items:center;gap:8px}
        .req-icon{font-size:18px}
        .req-list{display:flex;flex-direction:column;gap:8px}
        .req-item{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--text-2)}
        .req-item-dot{width:4px;height:4px;border-radius:50%;background:var(--accent);flex-shrink:0}

        .setup-card{background:var(--bg-2);border:1px solid var(--border);border-radius:var(--radius);padding:32px;margin-bottom:32px}
        .setup-title{font-family:var(--display);font-size:18px;font-weight:700;margin-bottom:24px}
        .setup-steps{display:flex;flex-direction:column;gap:0}
        .setup-step{display:flex;gap:16px;padding:16px 0;border-bottom:1px solid var(--border)}
        .setup-step:last-child{border-bottom:none}
        .setup-step-num{width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--accent-2));display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;color:white;flex-shrink:0;margin-top:2px}
        .setup-step-content h4{font-size:14px;font-weight:600;margin-bottom:4px}
        .setup-step-content p{font-size:13px;color:var(--text-2);line-height:1.55}
        .setup-step-code{background:var(--bg-3);border:1px solid var(--border);border-radius:6px;padding:8px 12px;font-family:var(--mono);font-size:12px;color:var(--accent-3);margin-top:8px;display:inline-block}

        .changelog-card{background:var(--bg-2);border:1px solid var(--border);border-radius:var(--radius);padding:28px}
        .changelog-title{font-family:var(--display);font-size:16px;font-weight:700;margin-bottom:20px}
        .changelog-version{display:flex;align-items:flex-start;gap:16px;padding:12px 0;border-bottom:1px solid var(--border)}
        .changelog-version:last-child{border-bottom:none;padding-bottom:0}
        .changelog-badge{background:rgba(108,99,255,0.1);border:1px solid rgba(108,99,255,0.2);color:var(--accent-2);border-radius:6px;padding:3px 10px;font-size:11px;font-weight:700;font-family:var(--mono);flex-shrink:0;margin-top:2px}
        .changelog-badge.latest{background:rgba(34,211,160,0.1);border-color:rgba(34,211,160,0.2);color:var(--green)}
        .changelog-items{display:flex;flex-direction:column;gap:4px}
        .changelog-item{font-size:13px;color:var(--text-2)}
        .changelog-item::before{content:'→ ';color:var(--accent);font-weight:600}

        footer{position:relative;z-index:1;border-top:1px solid var(--border);padding:48px 40px 32px;text-align:center}
        .footer-logo{font-family:var(--display);font-size:20px;font-weight:800;background:linear-gradient(135deg,#fff,var(--accent-2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:16px}
        .footer-links-row{display:flex;justify-content:center;gap:24px;flex-wrap:wrap;margin-bottom:24px}
        .footer-links-row a{font-size:13.5px;color:var(--text-2);transition:color 0.2s}
        .footer-links-row a:hover{color:var(--text)}
        .footer-copy{font-size:13px;color:var(--text-3)}

        ::-webkit-scrollbar{width:4px} ::-webkit-scrollbar-track{background:transparent} ::-webkit-scrollbar-thumb{background:var(--bg-4);border-radius:2px}
        @media(max-width:768px){nav{padding:0 20px}.nav-links{display:none}.page-header{padding:100px 20px 50px}.download-section{padding:20px 20px 60px}.requirements-grid{grid-template-columns:1fr}.download-hero{padding:40px 24px}}
    </style>
</head>
<body>

<div class="grid-bg"></div>
<div class="orb orb-1"></div>

<nav>
    <a href="{{ route('home') }}" class="nav-logo">Tunara</a>
    <ul class="nav-links">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('home') }}#how-it-works">How it Works</a></li>
        <li><a href="{{ route('home') }}#features">Features</a></li>
        <li><a href="{{ route('pricing') }}">Pricing</a></li>
        <li><a href="{{ route('download') }}" class="active">Download</a></li>
    </ul>
    <div class="nav-actions">
        @auth
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard →</a>
        @else
        <a href="{{ route('login') }}" class="btn btn-ghost">Sign in</a>
        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
        @endauth
    </div>
</nav>

<div class="page-header">
    <div class="page-tag">Download</div>
    <h1 class="page-title">Get the <span class="accent">Desktop App</span></h1>
    <p class="page-sub">The Tunara desktop app connects your local server to the relay. Lightweight, fast, and always ready.</p>
</div>

<div class="download-section">

    <!-- Main Download Card -->
    <div class="download-hero">
        <div class="download-app-icon">🚀</div>
        <div class="download-app-name">Tunara Desktop</div>
        <div class="download-version-badge">
            <span>●</span> v1.0.0 — Latest
        </div>
        <div class="download-desc">
            The official Tunara desktop application. Required to activate your tunnels and connect your local server to the internet.
        </div>

        <div class="download-btns">
            <a href="https://github.com/mohitsolanki7051/tunara-app/releases/download/v1.0.0/Tunara.Setup.1.0.0.exe" class="download-btn">
                <div class="download-btn-icon">🪟</div>
                <div>
                    <div class="download-btn-label">Download for</div>
                    <div class="download-btn-os">Windows</div>
                </div>
            </a>
        </div>

        <div class="download-meta">Windows 10 / 11 · 64-bit · ~80MB installer</div>
    </div>

    <!-- System Requirements -->
    <div class="requirements-grid">
        <div class="req-card">
            <div class="req-title"><span class="req-icon">🪟</span> Windows Requirements</div>
            <div class="req-list">
                <div class="req-item"><span class="req-item-dot"></span>Windows 10 or Windows 11</div>
                <div class="req-item"><span class="req-item-dot"></span>64-bit processor (x64)</div>
                <div class="req-item"><span class="req-item-dot"></span>4GB RAM minimum</div>
                <div class="req-item"><span class="req-item-dot"></span>Internet connection required</div>
                <div class="req-item"><span class="req-item-dot"></span>Administrator rights for install</div>
            </div>
        </div>

    </div>

    <!-- Setup Guide -->
    <div class="setup-card">
        <div class="setup-title">Installation & Setup Guide</div>
        <div class="setup-steps">
            <div class="setup-step">
                <div class="setup-step-num">1</div>
                <div class="setup-step-content">
                    <h4>Create your Tunara account</h4>
                    <p>Sign up for free at tunara.dev. Your account comes with a unique auth token.</p>
                </div>
            </div>
            <div class="setup-step">
                <div class="setup-step-num">2</div>
                <div class="setup-step-content">
                    <h4>Download and install the app</h4>
                    <p>Download the Windows installer above. Run it as Administrator. Installation takes less than a minute.</p>
                    <div class="setup-step-code">Run as Administrator → Follow installer prompts → Done</div>
                </div>
            </div>
            <div class="setup-step">
                <div class="setup-step-num">3</div>
                <div class="setup-step-content">
                    <h4>Create a tunnel from your dashboard</h4>
                    <p>Log in to your Tunara dashboard. Create a new tunnel with your local URL (e.g. http://localhost:8000).</p>
                </div>
            </div>
            <div class="setup-step">
                <div class="setup-step-num">4</div>
                <div class="setup-step-content">
                    <h4>Click "Open in App" — it auto-fills everything</h4>
                    <p>From the dashboard, click "Open in App." Your auth token and tunnel ID auto-fill in the desktop app. No copy-pasting needed.</p>
                </div>
            </div>
            <div class="setup-step">
                <div class="setup-step-num">5</div>
                <div class="setup-step-content">
                    <h4>Enter your local port and click Start Tunnel</h4>
                    <p>Enter the port your local server is running on (default: 8000). Click Start Tunnel. Your project is now accessible from anywhere.</p>
                    <div class="setup-step-code">Port: 8000 → Start Tunnel → ✓ Connected</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Changelog -->
    <div class="changelog-card">
        <div class="changelog-title">Release Notes</div>
        <div class="changelog-version">
            <div class="changelog-badge latest">v1.0.0</div>
            <div class="changelog-items">
                <div class="changelog-item">Initial release of Tunara Desktop</div>
                <div class="changelog-item">Secure WebSocket tunnel relay support</div>
                <div class="changelog-item">Deep link auto-fill from dashboard</div>
                <div class="changelog-item">Real-time request logs (GET, POST, PUT, DELETE)</div>
                <div class="changelog-item">Token-based authentication</div>
                <div class="changelog-item">Custom title bar with minimize/close controls</div>
            </div>
        </div>
    </div>

</div>

<footer>
    <div class="footer-logo">Tunara</div>
    <div class="footer-links-row">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('home') }}#features">Features</a>
        <a href="{{ route('pricing') }}">Pricing</a>
        <a href="{{ route('download') }}">Download</a>
        <a href="{{ route('login') }}">Sign In</a>
        <a href="{{ route('register') }}">Sign Up</a>
    </div>
    <div class="footer-copy">© {{ date('Y') }} Tunara. All rights reserved.</div>
</footer>

</body>
</html>

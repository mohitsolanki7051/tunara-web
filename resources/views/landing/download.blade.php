<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download — Tunara</title>
    <link rel="canonical" href="{{ url()->current() }}">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@300;400;500;600;700&family=Geist:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:#030305;--bg-2:#080810;--bg-3:#0d0d18;--bg-4:#12121f;
            --border:rgba(255,255,255,0.05);--border-2:rgba(255,255,255,0.1);--border-3:rgba(255,255,255,0.15);
            --text:#f0f0ff;--text-2:#7878a0;--text-3:#3a3a58;
            --accent:#5b7fff;--accent-2:#a78bfa;--accent-3:#22d3ee;
            --green:#10d98a;--red:#ff4d6a;--yellow:#fbbf24;
            --font:'Geist',sans-serif;--mono:'JetBrains Mono',monospace;
            --r:12px;--r-lg:20px;
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:var(--font);background:var(--bg);color:var(--text);-webkit-font-smoothing:antialiased;overflow-x:hidden;cursor:none}
        a{color:inherit;text-decoration:none}
        button{font-family:var(--font);cursor:none;border:none;background:none}

        .cursor{width:8px;height:8px;background:var(--accent);border-radius:50%;position:fixed;pointer-events:none;z-index:9999;transition:transform 0.1s ease;mix-blend-mode:screen}
        .cursor-ring{width:32px;height:32px;border:1px solid rgba(91,127,255,0.4);border-radius:50%;position:fixed;pointer-events:none;z-index:9998;transition:all 0.15s ease}

        .bg-mesh{position:fixed;inset:0;z-index:0;overflow:hidden;pointer-events:none}
        .mesh-orb{position:absolute;border-radius:50%;filter:blur(100px);animation:orbFloat 20s ease-in-out infinite}
        .orb-1{width:600px;height:600px;background:radial-gradient(circle,rgba(91,127,255,0.07) 0%,transparent 70%);top:-150px;right:-150px}
        .orb-2{width:350px;height:350px;background:radial-gradient(circle,rgba(34,211,238,0.04) 0%,transparent 70%);bottom:200px;left:-100px;animation-delay:-8s}
        @keyframes orbFloat{0%,100%{transform:translate(0,0)}50%{transform:translate(20px,-25px)}}
        .dot-grid{position:fixed;inset:0;z-index:0;pointer-events:none;background-image:radial-gradient(circle,rgba(255,255,255,0.04) 1px,transparent 1px);background-size:28px 28px;mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,black 40%,transparent 100%)}

        nav{position:fixed;top:0;left:0;right:0;z-index:100;padding:0 48px;height:56px;display:flex;align-items:center;justify-content:space-between;background:rgba(3,3,5,0.7);backdrop-filter:blur(24px) saturate(180%);border-bottom:1px solid var(--border)}
        .nav-logo{font-family:var(--font);font-size:15px;font-weight:700;color:var(--text);letter-spacing:-0.02em;display:flex;align-items:center;gap:8px}
        .nav-logo-dot{width:6px;height:6px;border-radius:50%;background:var(--green);animation:pulse 2s ease-in-out infinite}
        @keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:0.5;transform:scale(0.8)}}
        .nav-links{display:flex;align-items:center;gap:4px;list-style:none}
        .nav-links a{font-size:13px;font-weight:400;color:var(--text-2);padding:6px 12px;border-radius:6px;transition:color 0.2s,background 0.2s}
        .nav-links a:hover,.nav-links a.active{color:var(--text);background:rgba(255,255,255,0.04)}
        .nav-actions{display:flex;align-items:center;gap:8px}
        .btn{display:inline-flex;align-items:center;justify-content:center;gap:6px;font-family:var(--font);font-size:13px;font-weight:500;border-radius:8px;transition:all 0.2s;cursor:none;border:none;white-space:nowrap}
        .btn-ghost{background:transparent;color:var(--text-2);padding:7px 14px;border:1px solid var(--border-2)}
        .btn-ghost:hover{color:var(--text);border-color:var(--border-3);background:rgba(255,255,255,0.03)}
        .btn-primary{background:var(--accent);color:white;padding:8px 18px;font-weight:600;position:relative;overflow:hidden}
        .btn-primary::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,0.15) 0%,transparent 50%);opacity:0;transition:opacity 0.2s}
        .btn-primary:hover::before{opacity:1}
        .btn-primary:hover{transform:translateY(-1px);box-shadow:0 8px 24px rgba(91,127,255,0.35)}

        .page-hero{padding:120px 48px 64px;text-align:center;position:relative;z-index:1}
        .sec-label{font-family:var(--mono);font-size:10px;font-weight:500;letter-spacing:0.15em;text-transform:uppercase;color:var(--accent);margin-bottom:14px;display:flex;align-items:center;justify-content:center;gap:10px}
        .sec-label::before { display: none; }
        .page-title{font-size:clamp(32px,5vw,56px);font-weight:800;letter-spacing:-0.04em;line-height:1.08;margin-bottom:14px}
        .page-sub{font-size:15px;color:var(--text-2);max-width:420px;margin:0 auto;line-height:1.7}

        .download-section{padding:0 48px 100px;max-width:880px;margin:0 auto;position:relative;z-index:1}

        /* Main download card */
        .dl-hero{background:var(--bg-2);border:1px solid var(--border-2);border-radius:24px;padding:52px;text-align:center;position:relative;overflow:hidden;margin-bottom:24px}
        .dl-hero::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--accent),var(--accent-3),transparent)}
        .dl-icon{width:72px;height:72px;border-radius:18px;background:linear-gradient(135deg,var(--accent),var(--accent-2));display:flex;align-items:center;justify-content:center;font-size:32px;margin:0 auto 20px;box-shadow:0 16px 48px rgba(91,127,255,0.3)}
        .dl-app-name{font-size:22px;font-weight:700;letter-spacing:-0.02em;margin-bottom:8px}
        .dl-version-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(16,217,138,0.08);border:1px solid rgba(16,217,138,0.2);color:var(--green);border-radius:100px;padding:4px 12px;font-family:var(--mono);font-size:11px;font-weight:500;margin-bottom:18px}
        .dl-version-dot{width:5px;height:5px;border-radius:50%;background:var(--green);animation:pulse 2s infinite}
        .dl-desc{font-size:14px;color:var(--text-2);max-width:400px;margin:0 auto 28px;line-height:1.65}
        .dl-btn{display:inline-flex;align-items:center;gap:12px;background:var(--bg-3);border:1px solid var(--border-2);border-radius:10px;padding:12px 20px;transition:all 0.2s;margin-bottom:12px}
        .dl-btn:hover{border-color:var(--accent);transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,0.3)}
        .dl-btn-ico{font-size:22px}
        .dl-btn-label{font-size:10px;color:var(--text-3);font-family:var(--mono);text-align:left}
        .dl-btn-os{font-size:14px;font-weight:600}
        .dl-meta{font-family:var(--mono);font-size:11px;color:var(--text-3)}

        /* Requirements */
        .req-card{background:var(--bg-2);border:1px solid var(--border);border-radius:var(--r);padding:24px;margin-bottom:24px}
        .card-title{font-size:14px;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px;letter-spacing:-0.01em}
        .req-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:8px}
        .req-item{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--text-2)}
        .req-dot{width:4px;height:4px;border-radius:50%;background:var(--accent);flex-shrink:0}

        /* Setup steps */
        .setup-card{background:var(--bg-2);border:1px solid var(--border);border-radius:var(--r);padding:28px;margin-bottom:24px}
        .setup-step{display:flex;gap:14px;padding:14px 0;border-bottom:1px solid var(--border)}
        .setup-step:last-child{border-bottom:none;padding-bottom:0}
        .setup-step:first-child{padding-top:0}
        .step-num{width:26px;height:26px;border-radius:50%;background:var(--accent);display:flex;align-items:center;justify-content:center;font-family:var(--mono);font-size:11px;font-weight:700;color:white;flex-shrink:0;margin-top:1px}
        .step-body h4{font-size:13px;font-weight:600;margin-bottom:4px}
        .step-body p{font-size:13px;color:var(--text-2);line-height:1.6}
        .step-code{background:var(--bg-4);border:1px solid var(--border);border-radius:6px;padding:7px 11px;font-family:var(--mono);font-size:11px;color:var(--accent-3);margin-top:8px;display:inline-block}

        /* Changelog */
        .changelog-card{background:var(--bg-2);border:1px solid var(--border);border-radius:var(--r);padding:24px}
        .cl-item{display:flex;align-items:flex-start;gap:14px;padding:12px 0;border-bottom:1px solid var(--border)}
        .cl-item:last-child{border-bottom:none;padding-bottom:0}
        .cl-item:first-child{padding-top:0}
        .cl-badge{font-family:var(--mono);font-size:10px;font-weight:600;padding:3px 8px;border-radius:5px;flex-shrink:0;margin-top:2px}
        .cl-badge.latest{background:rgba(16,217,138,0.1);border:1px solid rgba(16,217,138,0.2);color:var(--green)}
        .cl-badge.old{background:var(--bg-4);border:1px solid var(--border-2);color:var(--text-3)}
        .cl-entries{display:flex;flex-direction:column;gap:4px}
        .cl-entry{font-size:12.5px;color:var(--text-2);display:flex;align-items:baseline;gap:6px}
        .cl-entry::before{content:'→';color:var(--accent);font-size:11px;flex-shrink:0}

        footer{position:relative;z-index:1;border-top:1px solid var(--border);padding:40px 48px 28px}
        .footer-inner{max-width:1160px;margin:0 auto;display:flex;align-items:center;justify-content:space-between}
        .footer-brand{font-family:var(--font);font-size:14px;font-weight:700}
        .footer-links{display:flex;align-items:center;gap:20px}
        .footer-links a{font-size:12px;color:var(--text-3);transition:color 0.15s}
        .footer-links a:hover{color:var(--text-2)}
        .footer-copy{font-family:var(--mono);font-size:11px;color:var(--text-3)}

        ::-webkit-scrollbar{width:3px} ::-webkit-scrollbar-track{background:transparent} ::-webkit-scrollbar-thumb{background:var(--bg-4)}
        @media(max-width:768px){body{cursor:auto}.cursor,.cursor-ring{display:none}nav{padding:0 20px}.nav-links{display:none}.page-hero{padding:88px 20px 48px}.download-section{padding:0 20px 72px}.dl-hero{padding:36px 20px}.req-grid{grid-template-columns:1fr}.footer-inner{flex-direction:column;gap:16px;text-align:center}}
    </style>
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
        <li><a href="{{ route('download') }}" class="active">Download</a></li>
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

<div class="page-hero">
    <div class="sec-label">download</div>
    <h1 class="page-title">Get the Desktop App</h1>
    <p class="page-sub">The bridge between your local server and the internet. Lightweight and always ready.</p>
</div>

<div class="download-section">

    <div class="dl-hero">
        <div class="dl-icon">🚀</div>
        <div class="dl-app-name">Tunara Desktop</div>
        <div class="dl-version-badge">
            <span class="dl-version-dot"></span>
            v1.0.0 — Latest release
        </div>
        <div class="dl-desc">The official desktop app. Required to activate your tunnels and connect your local server to the internet.</div>
        <div>
            <a href="https://github.com/mohitsolanki7051/tunara-app/releases/download/v1.0.0/Tunara.Setup.1.0.0.exe" class="dl-btn">
                <div class="dl-btn-ico">🪟</div>
                <div>
                    <div class="dl-btn-label">Download for</div>
                    <div class="dl-btn-os">Windows</div>
                </div>
            </a>
        </div>
        <div class="dl-meta">Windows 10/11 · 64-bit · ~80MB</div>
    </div>

    <!-- Requirements -->
    <div class="req-card">
        <div class="card-title">🪟 System Requirements</div>
        <div class="req-grid">
            <div class="req-item"><span class="req-dot"></span>Windows 10 or Windows 11</div>
            <div class="req-item"><span class="req-dot"></span>64-bit processor (x64)</div>
            <div class="req-item"><span class="req-dot"></span>4GB RAM minimum</div>
            <div class="req-item"><span class="req-dot"></span>Active internet connection</div>
            <div class="req-item"><span class="req-dot"></span>Admin rights for install</div>
            <div class="req-item"><span class="req-dot"></span>Tunara account required</div>
        </div>
    </div>

    <!-- Setup Guide -->
    <div class="setup-card">
        <div class="card-title">Installation Guide</div>
        <div class="setup-step">
            <div class="step-num">1</div>
            <div class="step-body">
                <h4>Create your Tunara account</h4>
                <p>Sign up free at tunara.online. Your account comes with a unique auth token.</p>
            </div>
        </div>
        <div class="setup-step">
            <div class="step-num">2</div>
            <div class="step-body">
                <h4>Download and install the app</h4>
                <p>Download the Windows installer above. Run as Administrator — installation takes under a minute.</p>
                <span class="step-code">Run as Administrator → Follow prompts → Done</span>
            </div>
        </div>
        <div class="setup-step">
            <div class="step-num">3</div>
            <div class="step-body">
                <h4>Create a tunnel from your dashboard</h4>
                <p>Log in to tunara.online. Click "New Tunnel" and enter your local URL (e.g. http://localhost:8000).</p>
            </div>
        </div>
        <div class="setup-step">
            <div class="step-num">4</div>
            <div class="step-body">
                <h4>Click "Open in App" — everything auto-fills</h4>
                <p>From the dashboard, click "Open in App." Your auth token and tunnel ID auto-fill in the desktop app. No copy-pasting needed.</p>
            </div>
        </div>
        <div class="setup-step">
            <div class="step-num">5</div>
            <div class="step-body">
                <h4>Click Start Tunnel — you're live</h4>
                <p>Enter your local project URL with port (e.g. http://localhost:8000) and click Start Tunnel. Your project is now accessible from anywhere in the world.</p>
                <span class="step-code">http://localhost:8000 → Start Tunnel → ✓ Connected</span>
            </div>
        </div>
    </div>

    <!-- Changelog -->
    <div class="changelog-card">
        <div class="card-title">Release Notes</div>
        <div class="cl-item">
            <div class="cl-badge latest">v1.0.0</div>
            <div class="cl-entries">
                <div class="cl-entry">Initial release of Tunara Desktop</div>
                <div class="cl-entry">Secure WebSocket tunnel relay support</div>
                <div class="cl-entry">Deep link auto-fill from dashboard</div>
                <div class="cl-entry">Real-time request logs (GET, POST, PUT, DELETE)</div>
                <div class="cl-entry">Token-based authentication</div>
                <div class="cl-entry">Custom title bar with minimize/close controls</div>
            </div>
        </div>
    </div>

</div>

<footer>
    <div class="footer-inner">
        <div class="footer-brand">Tunara</div>
        <div class="footer-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('home') }}#features">Features</a>
            <a href="{{ route('pricing') }}">Pricing</a>
            <a href="{{ route('download') }}">Download</a>
            <a href="{{ route('login') }}">Sign in</a>
        </div>
        <div class="footer-copy">© {{ date('Y') }} Tunara</div>
    </div>
</footer>

<script>
const cursor=document.getElementById('cursor');
const ring=document.getElementById('cursorRing');
let mx=0,my=0,rx=0,ry=0;
document.addEventListener('mousemove',e=>{mx=e.clientX;my=e.clientY;cursor.style.left=mx-4+'px';cursor.style.top=my-4+'px'});
function animRing(){rx+=(mx-rx)*0.12;ry+=(my-ry)*0.12;ring.style.left=rx-16+'px';ring.style.top=ry-16+'px';requestAnimationFrame(animRing)}
animRing();
document.querySelectorAll('a,button').forEach(el=>{
    el.addEventListener('mouseenter',()=>{cursor.style.transform='scale(2.5)';ring.style.transform='scale(1.5)';ring.style.borderColor='rgba(91,127,255,0.6)'});
    el.addEventListener('mouseleave',()=>{cursor.style.transform='scale(1)';ring.style.transform='scale(1)';ring.style.borderColor='rgba(91,127,255,0.4)'});
});
</script>
</body>
</html>

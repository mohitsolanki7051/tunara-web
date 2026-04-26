<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing — Tunara</title>
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
        html{scroll-behavior:smooth}
        body{font-family:var(--font);background:var(--bg);color:var(--text);-webkit-font-smoothing:antialiased;overflow-x:hidden;cursor:none}
        a{color:inherit;text-decoration:none}
        button{font-family:var(--font);cursor:none;border:none;background:none}

        .cursor{width:8px;height:8px;background:var(--accent);border-radius:50%;position:fixed;pointer-events:none;z-index:9999;transition:transform 0.1s ease;mix-blend-mode:screen}
        .cursor-ring{width:32px;height:32px;border:1px solid rgba(91,127,255,0.4);border-radius:50%;position:fixed;pointer-events:none;z-index:9998;transition:all 0.15s ease}

        .bg-mesh{position:fixed;inset:0;z-index:0;overflow:hidden;pointer-events:none}
        .mesh-orb{position:absolute;border-radius:50%;filter:blur(100px);animation:orbFloat 20s ease-in-out infinite}
        .orb-1{width:600px;height:600px;background:radial-gradient(circle,rgba(91,127,255,0.07) 0%,transparent 70%);top:-150px;right:-150px;animation-delay:0s}
        .orb-2{width:400px;height:400px;background:radial-gradient(circle,rgba(167,139,250,0.05) 0%,transparent 70%);bottom:100px;left:-100px;animation-delay:-10s}
        @keyframes orbFloat{0%,100%{transform:translate(0,0) scale(1)}50%{transform:translate(20px,-30px) scale(1.05)}}
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

        .page-hero{padding:120px 48px 72px;text-align:center;position:relative;z-index:1}
        .sec-label{font-family:var(--mono);font-size:10px;font-weight:500;letter-spacing:0.15em;text-transform:uppercase;color:var(--accent);margin-bottom:14px;display:flex;align-items:center;justify-content:center;gap:10px}
        .sec-label::before { display: none; }
        .page-title{font-size:clamp(32px,5vw,56px);font-weight:800;letter-spacing:-0.04em;line-height:1.08;margin-bottom:14px}
        .page-sub{font-size:15px;color:var(--text-2);max-width:440px;margin:0 auto;line-height:1.7}

        .pricing-section{padding:0 48px 100px;max-width:900px;margin:0 auto;position:relative;z-index:1}
        .pricing-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}

        .price-card{background:var(--bg-2);border:1px solid var(--border-2);border-radius:var(--r-lg);padding:32px;transition:transform 0.3s,border-color 0.3s}
        .price-card:hover{transform:translateY(-4px)}
        .price-card.pro{border-color:rgba(91,127,255,0.25);background:linear-gradient(135deg,rgba(91,127,255,0.06),rgba(167,139,250,0.02));position:relative;overflow:hidden}
        .price-card.pro::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--accent),var(--accent-2),transparent)}
        .price-badge{display:inline-flex;align-items:center;gap:5px;font-family:var(--mono);font-size:10px;font-weight:600;color:var(--accent);background:rgba(91,127,255,0.1);border:1px solid rgba(91,127,255,0.2);padding:3px 10px;border-radius:100px;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:18px}
        .price-plan{font-family:var(--mono);font-size:11px;font-weight:500;color:var(--text-3);letter-spacing:0.12em;text-transform:uppercase;margin-bottom:8px}
        .price-amount{font-size:48px;font-weight:700;letter-spacing:-0.05em;line-height:1;margin-bottom:6px}
        .price-amount sup{font-size:20px;font-weight:500;vertical-align:super}
        .price-period{font-size:13px;color:var(--text-3);font-weight:400}
        .price-desc{font-size:13px;color:var(--text-2);margin-bottom:22px;line-height:1.6;margin-top:8px}
        .price-div{height:1px;background:var(--border);margin-bottom:22px}
        .price-features{display:flex;flex-direction:column;gap:11px;margin-bottom:26px}
        .pf{display:flex;align-items:flex-start;gap:9px;font-size:13px;line-height:1.5}
        .pf-icon{width:15px;height:15px;flex-shrink:0;margin-top:1px}
        .pf-icon.on{color:var(--green)} .pf-icon.off{color:var(--text-3)}
        .pf.muted{color:var(--text-3)}
        .price-btn{width:100%;padding:11px;font-size:13px;font-weight:600;border-radius:8px;text-align:center;display:block;transition:all 0.2s}
        .price-btn.outline{border:1px solid var(--border-2);color:var(--text-2)}
        .price-btn.outline:hover{border-color:var(--border-3);color:var(--text);background:rgba(255,255,255,0.03)}
        .price-btn.fill{background:var(--accent);color:white;position:relative;overflow:hidden}
        .price-btn.fill::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(255,255,255,0.15),transparent);opacity:0;transition:opacity 0.2s}
        .price-btn.fill:hover::before{opacity:1}
        .price-btn.fill:hover{box-shadow:0 8px 24px rgba(91,127,255,0.35);transform:translateY(-1px)}
        .pricing-note{text-align:center;font-family:var(--mono);font-size:11px;color:var(--text-3);margin-top:16px}

        .faq-section{padding:72px 48px 100px;max-width:720px;margin:0 auto;position:relative;z-index:1}
        .faq-header{text-align:center;margin-bottom:48px}
        .faq-item{border-bottom:1px solid var(--border)}
        .faq-q{font-size:14px;font-weight:500;cursor:none;display:flex;align-items:center;justify-content:space-between;gap:12px;user-select:none;padding:18px 0;color:var(--text-2);transition:color 0.2s}
        .faq-q:hover{color:var(--text)}
        .faq-item.open .faq-q{color:var(--text)}
        .faq-icon{font-family:var(--mono);font-size:14px;color:var(--text-3);transition:transform 0.25s;flex-shrink:0}
        .faq-item.open .faq-icon{transform:rotate(45deg);color:var(--accent)}
        .faq-a{font-size:13px;color:var(--text-2);line-height:1.75;max-height:0;overflow:hidden;transition:max-height 0.3s ease,padding 0.3s ease}
        .faq-item.open .faq-a{max-height:200px;padding-bottom:18px}

        footer{position:relative;z-index:1;border-top:1px solid var(--border);padding:40px 48px 28px}
        .footer-inner{max-width:1160px;margin:0 auto;display:flex;align-items:center;justify-content:space-between}
        .footer-brand{font-family:var(--font);font-size:14px;font-weight:700;color:var(--text)}
        .footer-links{display:flex;align-items:center;gap:20px}
        .footer-links a{font-size:12px;color:var(--text-3);transition:color 0.15s}
        .footer-links a:hover{color:var(--text-2)}
        .footer-copy{font-family:var(--mono);font-size:11px;color:var(--text-3)}

        ::-webkit-scrollbar{width:3px} ::-webkit-scrollbar-track{background:transparent} ::-webkit-scrollbar-thumb{background:var(--bg-4)}
        @media(max-width:768px){body{cursor:auto}.cursor,.cursor-ring{display:none}nav{padding:0 20px}.nav-links{display:none}.page-hero{padding:88px 20px 52px}.pricing-section,.faq-section{padding:0 20px 72px}.pricing-grid{grid-template-columns:1fr}.footer-inner{flex-direction:column;gap:16px;text-align:center}}
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
        <li><a href="{{ route('pricing') }}" class="active">Pricing</a></li>
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

<div class="page-hero">
    <div class="sec-label">pricing</div>
    <h1 class="page-title">Simple, honest pricing</h1>
    <p class="page-sub">Start free. Upgrade when you need more. No hidden fees, no contracts.</p>
</div>

<div class="pricing-section">
    <div class="pricing-grid">
        <!-- FREE -->
        <div class="price-card">
            <div class="price-plan">Free</div>
            <div class="price-amount"><sup>₹</sup>0<span class="price-period"> /month</span></div>
            <div class="price-desc">Perfect for solo devs sharing projects with clients or teammates for review.</div>
            <div class="price-div"></div>
            <div class="price-features">
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>{{ $free->max_tunnels ?? 1 }} active tunnel at a time</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>{{ $free->max_requests_per_day == -1 ? 'Unlimited' : number_format($free->max_requests_per_day ?? 1000) }} requests/day</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Secure HTTPS tunnel</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Unlimited viewers</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Real-time request logs</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Deep link auto-fill</div>
                <div class="pf {{ $free->has_custom_subdomain ? '' : 'muted' }}"><svg class="pf-icon {{ $free->has_custom_subdomain ? 'on' : 'off' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">@if($free->has_custom_subdomain)<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>@else<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>@endif</svg>Custom subdomain</div>
                <div class="pf {{ $free->has_password_protection ? '' : 'muted' }}"><svg class="pf-icon {{ $free->has_password_protection ? 'on' : 'off' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">@if($free->has_password_protection)<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>@else<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>@endif</svg>Password protection</div>
                <div class="pf muted"><svg class="pf-icon off" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>Priority support</div>
            </div>
            <a href="{{ route('register') }}" class="price-btn outline">Get started free</a>
        </div>

        <!-- PRO -->
        <div class="price-card pro">
            <div class="price-badge">⭐ Most popular</div>
            <div class="price-plan">Pro</div>
            <div class="price-amount"><sup>₹</sup>{{ number_format($pro->price ?? 9, 0) }}<span class="price-period"> /month</span></div>
            <div class="price-desc">For professionals who need multiple tunnels, custom domains, and advanced security.</div>
            <div class="price-div"></div>
            <div class="price-features">
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>{{ $pro->max_tunnels ?? 5 }} active tunnels</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>{{ $pro->max_requests_per_day == -1 ? 'Unlimited' : number_format($pro->max_requests_per_day) }} requests/day</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Secure HTTPS tunnel</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Unlimited viewers</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Full logs & analytics</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Deep link auto-fill</div>
                <div class="pf {{ $pro->has_custom_subdomain ? '' : 'muted' }}"><svg class="pf-icon {{ $pro->has_custom_subdomain ? 'on' : 'off' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">@if($pro->has_custom_subdomain)<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>@else<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>@endif</svg>Custom subdomain</div>
                <div class="pf {{ $pro->has_password_protection ? '' : 'muted' }}"><svg class="pf-icon {{ $pro->has_password_protection ? 'on' : 'off' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">@if($pro->has_password_protection)<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>@else<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>@endif</svg>Password protection</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Priority support</div>
            </div>
            <button type="button" class="price-btn fill" onclick="openComingSoon()">Upgrade to Pro</button>
        </div>
    </div>
    <p class="pricing-note">All plans include unlimited viewers. Cancel anytime. No lock-in.</p>
</div>

<div class="faq-section">
    <div class="faq-header">
        <div class="sec-label">faq</div>
        <h2 style="font-size:clamp(24px,3vw,36px);font-weight:700;letter-spacing:-0.03em">Frequently asked questions</h2>
    </div>

    <div class="faq-item">
        <div class="faq-q">Do I need a credit card to sign up? <span class="faq-icon">+</span></div>
        <div class="faq-a">No. The free plan requires no credit card. You only need payment details when upgrading to Pro.</div>
    </div>
    <div class="faq-item">
        <div class="faq-q">Can I cancel my Pro subscription anytime? <span class="faq-icon">+</span></div>
        <div class="faq-a">Yes. Cancel anytime from your account settings. Your account reverts to the free plan at the end of the billing period.</div>
    </div>
    <div class="faq-item">
        <div class="faq-q">What happens when I reach my request limit? <span class="faq-icon">+</span></div>
        <div class="faq-a">On the free plan, additional requests are blocked until the next day once you hit your limit. Pro gives you unlimited requests.</div>
    </div>
    <div class="faq-item">
        <div class="faq-q">Is my data secure while using Tunara? <span class="faq-icon">+</span></div>
        <div class="faq-a">Yes. All tunnels use HTTPS with SSL. Tunara acts as a relay — we forward requests but don't store your HTTP traffic content. Token-based auth ensures only you control your tunnels.</div>
    </div>
    <div class="faq-item">
        <div class="faq-q">Can multiple people view my tunnel at the same time? <span class="faq-icon">+</span></div>
        <div class="faq-a">Yes. All plans support unlimited simultaneous viewers. Anyone with the URL can access your project as long as your tunnel is active.</div>
    </div>
    <div class="faq-item">
        <div class="faq-q">What frameworks does Tunara support? <span class="faq-icon">+</span></div>
        <div class="faq-a">Any framework that runs a local web server — Laravel, Next.js, Django, Rails, Express, Vue, React, and more. If it runs on localhost, Tunara tunnels it.</div>
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

<div id="coming-soon-modal" style="display:none;position:fixed;inset:0;z-index:1000;background:rgba(0,0,0,0.75);backdrop-filter:blur(12px);align-items:center;justify-content:center;padding:20px;">
    <div style="background:var(--bg-2);border:1px solid rgba(91,127,255,0.25);border-radius:24px;padding:48px 40px;max-width:420px;width:100%;text-align:center;position:relative;overflow:hidden;">
        <div style="position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--accent),var(--accent-2),transparent);"></div>
        <div style="font-family:var(--mono);font-size:10px;font-weight:600;letter-spacing:0.15em;text-transform:uppercase;color:var(--accent);margin-bottom:10px;">Coming Soon</div>
        <h3 style="font-size:22px;font-weight:700;letter-spacing:-0.02em;margin-bottom:10px;">Pro Plan Launching Soon</h3>
        <p style="font-size:13px;color:var(--text-2);line-height:1.7;margin-bottom:28px;">We are working hard to bring you the Pro plan with unlimited requests, multiple tunnels, and password protection. Please leave a review and help us grow — your feedback means a lot to us.</p>
        <div style="background:var(--bg-3);border:1px solid var(--border-2);border-radius:10px;padding:14px 18px;margin-bottom:24px;font-family:var(--mono);font-size:12px;color:var(--text-2);">
            <span style="color:var(--green);">✓</span> Free plan is fully live — start using it now
        </div>
        <button onclick="closeComingSoon()" style="width:100%;padding:12px;background:var(--accent);color:white;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;font-family:var(--font);">Got it!</button>
        <button onclick="closeComingSoon()" style="margin-top:10px;width:100%;padding:8px;background:none;border:none;font-size:13px;color:var(--text-3);cursor:pointer;font-family:var(--font);">Close</button>
    </div>
</div>

<script>
function openComingSoon() {
    document.getElementById('coming-soon-modal').style.display = 'flex';
}
function closeComingSoon() {
    document.getElementById('coming-soon-modal').style.display = 'none';
}
document.getElementById('coming-soon-modal').addEventListener('click', function(e) {
    if (e.target === this) closeComingSoon();
});
</script>

<script>
const cursor = document.getElementById('cursor');
const ring = document.getElementById('cursorRing');
let mx=0,my=0,rx=0,ry=0;
document.addEventListener('mousemove',e=>{mx=e.clientX;my=e.clientY;cursor.style.left=mx-4+'px';cursor.style.top=my-4+'px'});
function animRing(){rx+=(mx-rx)*0.12;ry+=(my-ry)*0.12;ring.style.left=rx-16+'px';ring.style.top=ry-16+'px';requestAnimationFrame(animRing)}
animRing();
document.querySelectorAll('a,button').forEach(el=>{
    el.addEventListener('mouseenter',()=>{cursor.style.transform='scale(2.5)';ring.style.transform='scale(1.5)';ring.style.borderColor='rgba(91,127,255,0.6)'});
    el.addEventListener('mouseleave',()=>{cursor.style.transform='scale(1)';ring.style.transform='scale(1)';ring.style.borderColor='rgba(91,127,255,0.4)'});
});
document.querySelectorAll('.faq-item').forEach(item=>{
    item.querySelector('.faq-q').addEventListener('click',()=>{
        const isOpen=item.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(i=>i.classList.remove('open'));
        if(!isOpen)item.classList.add('open');
    });
});
</script>
</body>
</html>

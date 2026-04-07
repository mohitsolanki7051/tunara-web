<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing — Tunara</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:#050508;--bg-2:#0a0a10;--bg-3:#111118;--bg-4:#18181f;
            --border:rgba(255,255,255,0.06);--border-2:rgba(255,255,255,0.12);
            --text:#f0f0ff;--text-2:#8888aa;--text-3:#44445a;
            --accent:#6c63ff;--accent-2:#a78bfa;--accent-3:#38bdf8;
            --green:#22d3a0;--red:#ff5f7e;--yellow:#fbbf24;
            --font:'DM Sans',sans-serif;--display:'Syne',sans-serif;
            --radius:16px;--radius-sm:10px;
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        html{scroll-behavior:smooth}
        body{font-family:var(--font);background:var(--bg);color:var(--text);-webkit-font-smoothing:antialiased;overflow-x:hidden}
        a{color:inherit;text-decoration:none}

        body::before{content:'';position:fixed;inset:0;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");pointer-events:none;z-index:1000;opacity:0.4}
        .grid-bg{position:fixed;inset:0;background-image:linear-gradient(rgba(108,99,255,0.03) 1px,transparent 1px),linear-gradient(90deg,rgba(108,99,255,0.03) 1px,transparent 1px);background-size:60px 60px;pointer-events:none;z-index:0}
        .orb{position:fixed;border-radius:50%;filter:blur(120px);pointer-events:none;z-index:0}
        .orb-1{width:500px;height:500px;background:rgba(108,99,255,0.08);top:-150px;right:-100px}
        .orb-2{width:350px;height:350px;background:rgba(56,189,248,0.05);bottom:100px;left:-80px}

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
        .btn-xl{padding:16px 40px;font-size:17px;border-radius:14px;font-weight:700}

        .page-header{padding:140px 40px 80px;text-align:center;position:relative;z-index:1}
        .page-tag{display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;color:var(--accent);margin-bottom:16px}
        .page-tag::before{content:'';width:20px;height:1px;background:var(--accent)}
        .page-title{font-family:var(--display);font-size:clamp(40px,6vw,72px);font-weight:800;letter-spacing:-0.04em;line-height:1.05;margin-bottom:16px}
        .page-title .accent{background:linear-gradient(135deg,var(--accent),var(--accent-2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .page-sub{font-size:18px;color:var(--text-2);max-width:500px;margin:0 auto;line-height:1.65}

        .pricing-section{padding:60px 40px 120px;max-width:1000px;margin:0 auto;position:relative;z-index:1}
        .pricing-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px}

        .pricing-card{background:var(--bg-2);border:1px solid var(--border);border-radius:24px;padding:40px;position:relative;transition:transform 0.3s}
        .pricing-card:hover{transform:translateY(-6px)}
        .pricing-card.featured{border-color:rgba(108,99,255,0.35);background:linear-gradient(135deg,rgba(108,99,255,0.07),rgba(167,139,250,0.03));box-shadow:0 0 60px rgba(108,99,255,0.12)}

        .pricing-badge{display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,var(--accent),var(--accent-2));color:white;font-size:11px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;padding:4px 14px;border-radius:100px;margin-bottom:20px}
        .pricing-plan{font-family:var(--display);font-size:14px;font-weight:700;color:var(--text-2);text-transform:uppercase;letter-spacing:0.12em;margin-bottom:8px}
        .pricing-price{font-family:var(--display);font-size:60px;font-weight:800;letter-spacing:-0.04em;line-height:1;margin-bottom:6px}
        .pricing-price sup{font-size:24px;font-weight:600;vertical-align:super;margin-right:2px}
        .pricing-price .period{font-size:15px;font-weight:400;color:var(--text-3)}
        .pricing-desc{font-size:14px;color:var(--text-2);margin-bottom:28px;line-height:1.6}
        .pricing-divider{height:1px;background:var(--border);margin-bottom:28px}
        .pricing-features{display:flex;flex-direction:column;gap:14px;margin-bottom:36px}
        .pricing-feature{display:flex;align-items:flex-start;gap:10px;font-size:14px;line-height:1.5}
        .pfi{width:17px;height:17px;flex-shrink:0;margin-top:2px}
        .pfi.yes{color:var(--green)} .pfi.no{color:var(--text-3)}
        .pricing-feature.dim{color:var(--text-3)}
        .pricing-cta{width:100%;padding:15px;font-size:15px;font-weight:600;border-radius:12px;text-align:center;display:block}

        .faq-section{padding:80px 40px 120px;max-width:760px;margin:0 auto;position:relative;z-index:1}
        .faq-title{font-family:var(--display);font-size:32px;font-weight:800;text-align:center;margin-bottom:48px}
        .faq-item{border-bottom:1px solid var(--border);padding:20px 0}
        .faq-q{font-size:16px;font-weight:600;cursor:pointer;display:flex;align-items:center;justify-content:space-between;gap:12px;user-select:none}
        .faq-icon{font-size:18px;color:var(--text-3);transition:transform 0.25s;flex-shrink:0}
        .faq-a{font-size:14px;color:var(--text-2);line-height:1.7;max-height:0;overflow:hidden;transition:max-height 0.3s ease,padding-top 0.3s ease}
        .faq-item.open .faq-a{max-height:200px;padding-top:14px}
        .faq-item.open .faq-icon{transform:rotate(45deg)}

        footer{position:relative;z-index:1;border-top:1px solid var(--border);padding:48px 40px 32px;text-align:center}
        .footer-logo{font-family:var(--display);font-size:20px;font-weight:800;background:linear-gradient(135deg,#fff,var(--accent-2));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:16px}
        .footer-links-row{display:flex;justify-content:center;gap:24px;flex-wrap:wrap;margin-bottom:24px}
        .footer-links-row a{font-size:13.5px;color:var(--text-2);transition:color 0.2s}
        .footer-links-row a:hover{color:var(--text)}
        .footer-copy{font-size:13px;color:var(--text-3)}

        ::-webkit-scrollbar{width:4px} ::-webkit-scrollbar-track{background:transparent} ::-webkit-scrollbar-thumb{background:var(--bg-4);border-radius:2px}
        @media(max-width:768px){nav{padding:0 20px}.nav-links{display:none}.pricing-grid{grid-template-columns:1fr}.page-header{padding:100px 20px 60px}.pricing-section,.faq-section{padding:40px 20px 80px}}
    </style>
</head>
<body>

<div class="grid-bg"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<nav>
    <a href="{{ route('home') }}" class="nav-logo">Tunara</a>
    <ul class="nav-links">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('home') }}#how-it-works">How it Works</a></li>
        <li><a href="{{ route('home') }}#features">Features</a></li>
        <li><a href="{{ route('pricing') }}" class="active">Pricing</a></li>
        <li><a href="{{ route('download') }}">Download</a></li>
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
    <div class="page-tag">Pricing</div>
    <h1 class="page-title">Simple, <span class="accent">honest</span> pricing</h1>
    <p class="page-sub">Start for free. Upgrade when you need more power. No hidden fees, no lock-in.</p>
</div>

<div class="pricing-section">
    <div class="pricing-grid">
        <!-- FREE -->
        <div class="pricing-card">
            <div class="pricing-plan">Free</div>
            <div class="pricing-price"><sup>₹</sup>0<span class="period">/month</span></div>
            <div class="pricing-desc">Perfect for solo developers sharing projects with clients or teammates for quick review and feedback.</div>
            <div class="pricing-divider"></div>
            <div class="pricing-features">
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ $free->max_tunnels ?? 1 }} active tunnel at a time</span>
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ $free->max_requests_per_day == -1 ? 'Unlimited' : number_format($free->max_requests_per_day ?? 1000) }} requests per day</span>
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Secure HTTPS tunnel</span>
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Unlimited viewers per tunnel</span>
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Real-time request logs in desktop app</span>
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Deep link auto-fill (Open in App)</span>
                </div>
                <div class="pricing-feature {{ $free->has_custom_subdomain ? '' : 'dim' }}">
                    <svg class="pfi {{ $free->has_custom_subdomain ? 'yes' : 'no' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($free->has_custom_subdomain)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        @endif
                    </svg>
                    <span>Custom subdomain</span>
                </div>
                <div class="pricing-feature {{ $free->has_password_protection ? '' : 'dim' }}">
                    <svg class="pfi {{ $free->has_password_protection ? 'yes' : 'no' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($free->has_password_protection)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        @endif
                    </svg>
                    <span>Password-protected tunnels</span>
                </div>
                <div class="pricing-feature dim">
                    <svg class="pfi no" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    <span>Priority support</span>
                </div>
            </div>
            <a href="{{ route('register') }}" class="btn btn-ghost pricing-cta">Get Started Free</a>
        </div>

        <!-- PRO -->
        <div class="pricing-card featured">
            <div class="pricing-badge">⭐ Most Popular</div>
            <div class="pricing-plan">Pro</div>
            <div class="pricing-price"><sup>₹</sup>{{ number_format($pro->price ?? 9, 0) }}<span class="period">/month</span></div>
            <div class="pricing-desc">For professionals who need multiple tunnels, custom domains, password protection, and priority support.</div>
            <div class="pricing-divider"></div>
            <div class="pricing-features">
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ $pro->max_tunnels ?? 5 }} active tunnels at a time</span>
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ $pro->max_requests_per_day == -1 ? 'Unlimited' : number_format($pro->max_requests_per_day) }} requests per day</span>
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Secure HTTPS tunnel</span>
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Unlimited viewers per tunnel</span>
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Full logs & analytics dashboard</span>
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Deep link auto-fill (Open in App)</span>
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Custom subdomain (yourname.tunara.dev)</span>
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Password-protected tunnel URLs</span>
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Priority support</span>
                </div>
            </div>
            <a href="{{ route('register') }}" class="btn btn-primary pricing-cta">Upgrade to Pro</a>
        </div>
    </div>

    <p style="text-align:center;font-size:13px;color:var(--text-3);margin-top:28px;">All plans include unlimited viewers. Pay monthly, cancel anytime. No contracts.</p>
</div>

<!-- FAQ -->
<div class="faq-section">
    <div class="faq-title">Frequently asked questions</div>

    <div class="faq-item">
        <div class="faq-q">
            Do I need a credit card to sign up?
            <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">No. The free plan requires no credit card. You only need to provide payment details when upgrading to Pro.</div>
    </div>

    <div class="faq-item">
        <div class="faq-q">
            Can I cancel my Pro subscription anytime?
            <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">Yes, absolutely. You can cancel your Pro subscription at any time from your account settings. Your account will revert to the free plan at the end of the billing period.</div>
    </div>

    <div class="faq-item">
        <div class="faq-q">
            What happens when I reach my request limit?
            <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">On the free plan, once you reach your daily request limit, additional requests will be blocked until the next day. Upgrading to Pro gives you unlimited requests.</div>
    </div>

    <div class="faq-item">
        <div class="faq-q">
            Is my data secure while using Tunara?
            <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">Yes. All tunnels use HTTPS with SSL certificates. Tunara acts as a relay — we forward requests but do not store the content of your HTTP traffic. Your auth token ensures only you can control your tunnels.</div>
    </div>

    <div class="faq-item">
        <div class="faq-q">
            Can multiple people view my tunnel URL at the same time?
            <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">Yes! All plans support unlimited simultaneous viewers. Anyone with the public URL can access your local project as long as your desktop app tunnel is active.</div>
    </div>

    <div class="faq-item">
        <div class="faq-q">
            What frameworks and languages does Tunara support?
            <span class="faq-icon">+</span>
        </div>
        <div class="faq-a">Any framework or language that runs a local web server — Laravel, Next.js, Django, Rails, Express, Vue, React, and more. If it runs on localhost with a port, Tunara can tunnel it.</div>
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

<script>
    document.querySelectorAll('.faq-item').forEach(item => {
        item.querySelector('.faq-q').addEventListener('click', () => {
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
            if (!isOpen) item.classList.add('open');
        });
    });
</script>
</body>
</html>

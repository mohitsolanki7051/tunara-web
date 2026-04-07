<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tunara — Share Your Local Project Instantly</title>
    <meta name="description" content="Tunara lets you expose your local development server to the internet in seconds. No port forwarding, no configuration. Just create a tunnel and share.">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #050508;
            --bg-2: #0a0a10;
            --bg-3: #111118;
            --bg-4: #18181f;
            --border: rgba(255,255,255,0.06);
            --border-2: rgba(255,255,255,0.12);
            --text: #f0f0ff;
            --text-2: #8888aa;
            --text-3: #44445a;
            --accent: #6c63ff;
            --accent-2: #a78bfa;
            --accent-3: #38bdf8;
            --green: #22d3a0;
            --red: #ff5f7e;
            --yellow: #fbbf24;
            --font: 'DM Sans', sans-serif;
            --display: 'Syne', sans-serif;
            --mono: 'DM Mono', monospace;
            --radius: 16px;
            --radius-sm: 10px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font); background: var(--bg); color: var(--text); -webkit-font-smoothing: antialiased; overflow-x: hidden; }
        a { color: inherit; text-decoration: none; }
        button { font-family: var(--font); cursor: pointer; border: none; background: none; }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 1000;
            opacity: 0.4;
        }

        .grid-bg {
            position: fixed;
            inset: 0;
            background-image: linear-gradient(rgba(108,99,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(108,99,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
            z-index: 0;
        }

        .orb { position: fixed; border-radius: 50%; filter: blur(120px); pointer-events: none; z-index: 0; }
        .orb-1 { width: 600px; height: 600px; background: rgba(108,99,255,0.08); top: -200px; right: -100px; }
        .orb-2 { width: 400px; height: 400px; background: rgba(56,189,248,0.06); bottom: 200px; left: -100px; }
        .orb-3 { width: 300px; height: 300px; background: rgba(167,139,250,0.06); top: 50%; left: 50%; transform: translate(-50%,-50%); }

        /* NAVBAR */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            padding: 0 40px; height: 64px;
            display: flex; align-items: center; justify-content: space-between;
            background: rgba(5,5,8,0.85); backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }
        .nav-logo { font-family: var(--display); font-size: 22px; font-weight: 800; background: linear-gradient(135deg, #fff 0%, var(--accent-2) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .nav-links { display: flex; align-items: center; gap: 32px; list-style: none; }
        .nav-links a { font-size: 14px; font-weight: 500; color: var(--text-2); transition: color 0.2s; }
        .nav-links a:hover, .nav-links a.active { color: var(--text); }
        .nav-actions { display: flex; align-items: center; gap: 12px; }

        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-family: var(--font); font-weight: 500; border-radius: var(--radius-sm); transition: all 0.2s; cursor: pointer; border: none; font-size: 14px; }
        .btn-ghost { background: transparent; color: var(--text-2); padding: 8px 18px; border: 1px solid var(--border); }
        .btn-ghost:hover { border-color: var(--border-2); color: var(--text); }
        .btn-primary { background: linear-gradient(135deg, var(--accent), var(--accent-2)); color: white; padding: 10px 22px; font-weight: 600; box-shadow: 0 0 30px rgba(108,99,255,0.25); }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); box-shadow: 0 0 40px rgba(108,99,255,0.4); }
        .btn-lg { padding: 14px 32px; font-size: 16px; border-radius: 12px; }
        .btn-xl { padding: 16px 40px; font-size: 17px; border-radius: 14px; font-weight: 700; }

        /* HERO */
        .hero {
            position: relative; z-index: 1;
            min-height: 100vh;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; padding: 120px 40px 80px;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(108,99,255,0.1); border: 1px solid rgba(108,99,255,0.25);
            border-radius: 100px; padding: 6px 16px; font-size: 13px; color: var(--accent-2);
            font-weight: 500; margin-bottom: 32px;
            animation: fadeInDown 0.6s ease both;
        }
        .hero-badge-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--green); animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }

        .hero-title {
            font-family: var(--display);
            font-size: clamp(48px, 7vw, 96px);
            font-weight: 800; line-height: 1.0; letter-spacing: -0.04em;
            max-width: 900px; margin-bottom: 24px;
            animation: fadeInUp 0.7s ease 0.1s both;
        }
        .hero-title .accent {
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-2) 50%, var(--accent-3) 100%);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .hero-sub {
            font-size: clamp(16px, 2vw, 20px); color: var(--text-2);
            max-width: 560px; line-height: 1.65; margin-bottom: 48px;
            animation: fadeInUp 0.7s ease 0.2s both;
        }
        .hero-cta { display: flex; align-items: center; gap: 16px; flex-wrap: wrap; justify-content: center; margin-bottom: 64px; animation: fadeInUp 0.7s ease 0.3s both; }

        .hero-terminal {
            width: 100%; max-width: 680px;
            background: var(--bg-2); border: 1px solid var(--border);
            border-radius: 16px; overflow: hidden;
            box-shadow: 0 40px 120px rgba(0,0,0,0.6), 0 0 0 1px rgba(108,99,255,0.1);
            animation: fadeInUp 0.8s ease 0.4s both;
        }
        .terminal-bar { background: var(--bg-3); padding: 12px 16px; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid var(--border); }
        .terminal-dot { width: 10px; height: 10px; border-radius: 50%; }
        .td-red{background:#ff5f57} .td-yellow{background:#febc2e} .td-green{background:#28c840}
        .terminal-title { font-size: 12px; color: var(--text-3); margin-left: auto; font-family: var(--mono); }
        .terminal-body { padding: 20px 24px; font-family: var(--mono); font-size: 13px; line-height: 1.8; text-align: left; }
        .t-comment{color:var(--text-3)} .t-cmd{color:var(--text-2)} .t-cmd::before{content:'$ ';color:var(--accent)}
        .t-out{color:var(--green)} .t-url{color:var(--accent-3)} .t-highlight{color:var(--yellow)}
        .typing-cursor { display: inline-block; width: 8px; height: 14px; background: var(--accent); animation: blink 1s step-end infinite; vertical-align: middle; border-radius: 1px; }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }

        /* STATS */
        .stats-bar {
            position: relative; z-index: 1;
            display: flex; align-items: center; justify-content: center;
            gap: 60px; padding: 48px 40px; flex-wrap: wrap;
            border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
        }
        .stat-item { text-align: center; }
        .stat-num { font-family: var(--display); font-size: 36px; font-weight: 800; background: linear-gradient(135deg, var(--text), var(--accent-2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .stat-label { font-size: 13px; color: var(--text-3); margin-top: 4px; }
        .stat-divider { width: 1px; height: 40px; background: var(--border); }

        /* SECTIONS */
        section { position: relative; z-index: 1; }
        .section-tag { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; color: var(--accent); margin-bottom: 16px; }
        .section-tag::before { content: ''; width: 20px; height: 1px; background: var(--accent); }
        .section-title { font-family: var(--display); font-size: clamp(32px, 4vw, 52px); font-weight: 800; letter-spacing: -0.03em; line-height: 1.1; margin-bottom: 16px; }
        .section-sub { font-size: 17px; color: var(--text-2); line-height: 1.6; max-width: 520px; }

        /* HOW IT WORKS */
        .how-section { padding: 120px 40px; max-width: 1200px; margin: 0 auto; }
        .how-header { margin-bottom: 80px; }

        .steps-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; position: relative; }
        .steps-grid::before {
            content: '';
            position: absolute;
            top: 52px; left: calc(12.5% + 10px); right: calc(12.5% + 10px);
            height: 1px;
            background: linear-gradient(90deg, var(--accent), var(--accent-2), var(--accent-3));
            opacity: 0.3;
        }

        .step-card {
            background: var(--bg-2); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 28px;
            text-align: center;
            opacity: 0; transform: translateY(24px);
            transition: opacity 0.5s ease, transform 0.5s ease, border-color 0.3s, box-shadow 0.3s;
        }
        .step-card.visible { opacity: 1; transform: translateY(0); }
        .step-card:nth-child(2){transition-delay:0.1s} .step-card:nth-child(3){transition-delay:0.2s} .step-card:nth-child(4){transition-delay:0.3s}
        .step-card:hover { border-color: rgba(108,99,255,0.3); box-shadow: 0 20px 60px rgba(0,0,0,0.3); }

        .step-num-circle {
            width: 44px; height: 44px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            display: flex; align-items: center; justify-content: center;
            font-family: var(--display); font-size: 16px; font-weight: 800;
            color: white; margin: 0 auto 20px;
            box-shadow: 0 8px 24px rgba(108,99,255,0.3);
        }
        .step-emoji { font-size: 28px; margin-bottom: 12px; }
        .step-title { font-family: var(--display); font-size: 17px; font-weight: 700; margin-bottom: 10px; }
        .step-desc { font-size: 13.5px; color: var(--text-2); line-height: 1.65; }
        .step-code { background: var(--bg-3); border: 1px solid var(--border); border-radius: 8px; padding: 10px 12px; font-family: var(--mono); font-size: 11px; color: var(--text-2); margin-top: 14px; text-align: left; }
        .step-code .sc-green{color:var(--green)} .step-code .sc-blue{color:var(--accent-3)}

        /* FEATURES */
        .features-section { padding: 120px 40px; max-width: 1200px; margin: 0 auto; }
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 60px; }
        .feature-card {
            background: var(--bg-2); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 28px;
            position: relative; overflow: hidden;
            opacity: 0; transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease, border-color 0.3s;
        }
        .feature-card.visible { opacity: 1; transform: translateY(0); }
        .feature-card:nth-child(2){transition-delay:0.08s} .feature-card:nth-child(3){transition-delay:0.16s}
        .feature-card:nth-child(4){transition-delay:0.08s} .feature-card:nth-child(5){transition-delay:0.16s} .feature-card:nth-child(6){transition-delay:0.24s}
        .feature-card::after { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--accent), transparent); opacity: 0; transition: opacity 0.3s; }
        .feature-card:hover { border-color: rgba(108,99,255,0.25); transform: translateY(-4px) !important; }
        .feature-card:hover::after { opacity: 1; }
        .feature-icon { width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 16px; }
        .feature-title { font-family: var(--display); font-size: 17px; font-weight: 700; margin-bottom: 8px; }
        .feature-desc { font-size: 13.5px; color: var(--text-2); line-height: 1.65; }

        /* ARCHITECTURE */
        .arch-section {
            padding: 100px 40px;
            background: linear-gradient(to bottom, transparent, rgba(108,99,255,0.03), transparent);
            border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
        }
        .arch-inner { max-width: 1000px; margin: 0 auto; text-align: center; }
        .arch-diagram { margin-top: 60px; display: flex; align-items: center; justify-content: center; flex-wrap: wrap; gap: 0; }
        .arch-node { background: var(--bg-2); border: 1px solid var(--border); border-radius: 14px; padding: 18px 22px; text-align: center; min-width: 130px; }
        .arch-node-icon { font-size: 28px; margin-bottom: 8px; }
        .arch-node-label { font-size: 13px; font-weight: 600; }
        .arch-node-sub { font-size: 11px; color: var(--text-3); margin-top: 3px; }
        .arch-arrow { display: flex; align-items: center; padding: 0 6px; }
        .arch-line { width: 40px; height: 2px; background: linear-gradient(90deg, rgba(108,99,255,0.5), rgba(108,99,255,0.1)); position: relative; }
        .arch-line::after { content: '▶'; position: absolute; right: -7px; top: -7px; font-size: 10px; color: var(--accent); opacity: 0.6; }

        /* PRICING */
        .pricing-section { padding: 120px 40px; max-width: 960px; margin: 0 auto; }
        .pricing-toggle { display: flex; align-items: center; justify-content: center; gap: 16px; margin: 32px 0 0; }
        .pricing-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-top: 48px; }
        .pricing-card {
            background: var(--bg-2); border: 1px solid var(--border);
            border-radius: 20px; padding: 36px;
            position: relative; transition: transform 0.3s;
        }
        .pricing-card:hover { transform: translateY(-6px); }
        .pricing-card.featured {
            border-color: rgba(108,99,255,0.35);
            background: linear-gradient(135deg, rgba(108,99,255,0.07), rgba(167,139,250,0.03));
            box-shadow: 0 0 60px rgba(108,99,255,0.12);
        }
        .pricing-badge { display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(135deg, var(--accent), var(--accent-2)); color: white; font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; padding: 4px 12px; border-radius: 100px; margin-bottom: 20px; }
        .pricing-plan { font-family: var(--display); font-size: 14px; font-weight: 700; color: var(--text-2); text-transform: uppercase; letter-spacing: 0.12em; margin-bottom: 8px; }
        .pricing-price { font-family: var(--display); font-size: 56px; font-weight: 800; letter-spacing: -0.04em; line-height: 1; margin-bottom: 6px; }
        .pricing-price sup { font-size: 24px; font-weight: 600; vertical-align: super; margin-right: 2px; }
        .pricing-price .period { font-size: 15px; font-weight: 400; color: var(--text-3); }
        .pricing-desc { font-size: 14px; color: var(--text-2); margin-bottom: 24px; line-height: 1.55; }
        .pricing-divider { height: 1px; background: var(--border); margin-bottom: 24px; }
        .pricing-features { display: flex; flex-direction: column; gap: 13px; margin-bottom: 32px; }
        .pricing-feature { display: flex; align-items: center; gap: 10px; font-size: 14px; }
        .pfi { width: 17px; height: 17px; flex-shrink: 0; }
        .pfi.yes{color:var(--green)} .pfi.no{color:var(--text-3)}
        .pricing-feature.dim { color: var(--text-3); }
        .pricing-cta { width: 100%; padding: 14px; font-size: 15px; font-weight: 600; border-radius: 12px; text-align: center; }

        /* TESTIMONIALS */
        .testimonials-section { padding: 100px 40px; max-width: 1100px; margin: 0 auto; }
        .testimonials-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 56px; }
        .testimonial-card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); padding: 24px; opacity: 0; transform: translateY(16px); transition: opacity 0.5s ease, transform 0.5s ease; }
        .testimonial-card.visible { opacity: 1; transform: translateY(0); }
        .testimonial-card:nth-child(2){transition-delay:0.1s} .testimonial-card:nth-child(3){transition-delay:0.2s}
        .testimonial-stars { color: var(--yellow); font-size: 14px; margin-bottom: 14px; }
        .testimonial-text { font-size: 14px; color: var(--text-2); line-height: 1.7; margin-bottom: 18px; }
        .testimonial-author { display: flex; align-items: center; gap: 10px; }
        .testimonial-avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), var(--accent-2)); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; color: white; }
        .testimonial-name { font-size: 13px; font-weight: 600; }
        .testimonial-role { font-size: 12px; color: var(--text-3); }

        /* DOWNLOAD */
        .download-section { padding: 100px 40px; max-width: 800px; margin: 0 auto; text-align: center; }
        .download-card { background: var(--bg-2); border: 1px solid var(--border); border-radius: 24px; padding: 56px; margin-top: 48px; position: relative; overflow: hidden; }
        .download-card::before { content: ''; position: absolute; top: -80px; right: -80px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(108,99,255,0.12), transparent 70%); pointer-events: none; }
        .download-app-icon { width: 80px; height: 80px; border-radius: 20px; background: linear-gradient(135deg, var(--accent), var(--accent-2)); display: flex; align-items: center; justify-content: center; font-size: 36px; margin: 0 auto 24px; box-shadow: 0 20px 60px rgba(108,99,255,0.3); }
        .download-title { font-family: var(--display); font-size: 30px; font-weight: 800; margin-bottom: 10px; }
        .download-sub { font-size: 15px; color: var(--text-2); margin-bottom: 32px; line-height: 1.6; }
        .download-btns { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }
        .download-btn { display: flex; align-items: center; gap: 12px; background: var(--bg-3); border: 1px solid var(--border-2); border-radius: 12px; padding: 14px 24px; transition: all 0.2s; min-width: 170px; }
        .download-btn:hover { border-color: var(--accent); transform: translateY(-2px); }
        .download-btn-icon { font-size: 26px; }
        .download-btn-label { font-size: 11px; color: var(--text-3); }
        .download-btn-os { font-size: 15px; font-weight: 600; }
        .download-version { font-size: 12px; color: var(--text-3); margin-top: 20px; }

        /* CTA */
        .cta-section { padding: 100px 40px; text-align: center; position: relative; z-index: 1; }
        .cta-inner { max-width: 680px; margin: 0 auto; background: linear-gradient(135deg, rgba(108,99,255,0.08), rgba(167,139,250,0.04)); border: 1px solid rgba(108,99,255,0.2); border-radius: 28px; padding: 80px 60px; position: relative; overflow: hidden; }
        .cta-inner::before { content: ''; position: absolute; top: -60px; left: 50%; transform: translateX(-50%); width: 300px; height: 300px; background: radial-gradient(circle, rgba(108,99,255,0.18), transparent 70%); }
        .cta-title { font-family: var(--display); font-size: clamp(32px, 4vw, 48px); font-weight: 800; letter-spacing: -0.03em; margin-bottom: 14px; }
        .cta-sub { font-size: 17px; color: var(--text-2); margin-bottom: 40px; line-height: 1.6; }

        /* FOOTER */
        footer { position: relative; z-index: 1; border-top: 1px solid var(--border); padding: 60px 40px 36px; }
        .footer-inner { max-width: 1200px; margin: 0 auto; }
        .footer-top { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 60px; margin-bottom: 48px; }
        .footer-brand-name { font-family: var(--display); font-size: 22px; font-weight: 800; background: linear-gradient(135deg, #fff, var(--accent-2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; margin-bottom: 12px; }
        .footer-brand-desc { font-size: 13px; color: var(--text-3); line-height: 1.7; max-width: 240px; }
        .footer-col-title { font-size: 12px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--text-3); margin-bottom: 16px; }
        .footer-links { display: flex; flex-direction: column; gap: 10px; }
        .footer-links a { font-size: 13.5px; color: var(--text-2); transition: color 0.2s; }
        .footer-links a:hover { color: var(--text); }
        .footer-bottom { display: flex; align-items: center; justify-content: space-between; padding-top: 24px; border-top: 1px solid var(--border); font-size: 13px; color: var(--text-3); }

        @keyframes fadeInDown { from{opacity:0;transform:translateY(-16px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeInUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--bg-4); border-radius: 2px; }

        @media(max-width:768px) {
            nav { padding: 0 20px; }
            .nav-links { display: none; }
            .hero { padding: 100px 20px 60px; }
            .stats-bar { gap: 24px; padding: 32px 20px; }
            .stat-divider { display: none; }
            .how-section,.features-section,.pricing-section,.download-section,.testimonials-section { padding: 80px 20px; }
            .steps-grid,.features-grid,.pricing-grid,.testimonials-grid { grid-template-columns: 1fr; }
            .steps-grid::before { display: none; }
            .footer-top { grid-template-columns: 1fr 1fr; gap: 32px; }
            .arch-section { padding: 80px 20px; }
            .arch-node { min-width: 90px; padding: 12px 10px; }
            .arch-line { width: 18px; }
            .cta-inner { padding: 48px 28px; }
            .download-card { padding: 36px 24px; }
        }
    </style>
</head>
<body>

<div class="grid-bg"></div>
<div class="orb orb-1"></div>
<div class="orb orb-2"></div>
<div class="orb orb-3"></div>

<!-- NAVBAR -->
<nav>
    <a href="{{ route('home') }}" class="nav-logo">Tunara</a>
    <ul class="nav-links">
        <li><a href="{{ route('home') }}" class="active">Home</a></li>
        <li><a href="#how-it-works">How it Works</a></li>
        <li><a href="#features">Features</a></li>
        <li><a href="{{ route('pricing') }}">Pricing</a></li>
        <li><a href="{{ route('download') }}">Download</a></li>
    </ul>
    <div class="nav-actions">
        @auth
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard →</a>
        @else
        <a href="{{ route('login') }}" class="btn btn-ghost">Sign in</a>
        <a href="{{ route('register') }}" class="btn btn-primary">Get Started Free</a>
        @endauth
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-badge">
        <span class="hero-badge-dot"></span>
        Free plan available · No credit card required
    </div>

    <h1 class="hero-title">
        Share your local project<br>
        <span class="accent">without the hassle</span>
    </h1>

    <p class="hero-sub">
        Tunara creates a secure public URL for your local development server in seconds. No port forwarding, no complex config. Just install, click, and share.
    </p>

    <div class="hero-cta">
        <a href="{{ route('register') }}" class="btn btn-primary btn-xl">
            Start for Free
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </a>
        <a href="{{ route('download') }}" class="btn btn-ghost btn-lg">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download App
        </a>
    </div>

    <div class="hero-terminal">
        <div class="terminal-bar">
            <div class="terminal-dot td-red"></div>
            <div class="terminal-dot td-yellow"></div>
            <div class="terminal-dot td-green"></div>
            <span class="terminal-title">tunara — active tunnel</span>
        </div>
        <div class="terminal-body">
            <div class="t-comment"># Tunnel connected and ready</div>
            <br>
            <div class="t-out">✓ Auth token verified</div>
            <div class="t-out">✓ Tunnel registered on relay server</div>
            <div class="t-out">✓ WebSocket connection established</div>
            <br>
            <div>Public URL → <span class="t-url">https://tunara.dev/t/a8f2k9m1</span></div>
            <div style="color:var(--text-3)">Local URL → <span style="color:var(--text-2)">http://localhost:8000</span></div>
            <br>
            <div class="t-highlight">⚡ Share the public URL — your project is now live!</div>
            <br>
            <div class="t-comment">GET  /               200  <span style="color:var(--green)">22ms</span></div>
            <div class="t-comment">GET  /dashboard      200  <span style="color:var(--green)">18ms</span></div>
            <div class="t-comment">POST /api/login      200  <span style="color:var(--green)">34ms</span></div>
            <div class="t-comment">GET  /api/data       200  <span style="color:var(--green)">29ms</span> <span class="typing-cursor"></span></div>
        </div>
    </div>
</section>

<!-- STATS -->
<div class="stats-bar">
    <div class="stat-item">
        <div class="stat-num">&lt; 60s</div>
        <div class="stat-label">From install to live URL</div>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
        <div class="stat-num">HTTPS</div>
        <div class="stat-label">Secure by default</div>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
        <div class="stat-num">Free</div>
        <div class="stat-label">No credit card needed</div>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
        <div class="stat-num">Any</div>
        <div class="stat-label">Framework supported</div>
    </div>
    <div class="stat-divider"></div>
    <div class="stat-item">
        <div class="stat-num">∞</div>
        <div class="stat-label">Viewers per tunnel</div>
    </div>
</div>

<!-- HOW IT WORKS -->
<section id="how-it-works" class="how-section">
    <div class="how-header">
        <div class="section-tag">How it works</div>
        <h2 class="section-title">Live in 4 simple steps</h2>
        <p class="section-sub">From zero to a shareable public URL in under a minute. No technical knowledge required beyond running a local server.</p>
    </div>

    <div class="steps-grid">
        <div class="step-card" data-scroll>
            <div class="step-num-circle">1</div>
            <div class="step-emoji">🔐</div>
            <div class="step-title">Create Your Account</div>
            <div class="step-desc">Sign up for free in seconds. No credit card. Your account gets a unique auth token that securely connects your desktop app to the relay.</div>
            <div class="step-code">
                <span class="sc-green">✓</span> Account created<br>
                Token: <span class="sc-blue">a9f2k8m1...</span>
            </div>
        </div>

        <div class="step-card" data-scroll>
            <div class="step-num-circle">2</div>
            <div class="step-emoji">📥</div>
            <div class="step-title">Install Desktop App</div>
            <div class="step-desc">Download the lightweight Tunara desktop app for Windows. It acts as a secure bridge between your local dev server and the public internet.</div>
            <div class="step-code">
                <span class="sc-blue">Tunara-Setup.exe</span><br>
                <span class="sc-green">✓</span> Installed & ready
            </div>
        </div>

        <div class="step-card" data-scroll>
            <div class="step-num-circle">3</div>
            <div class="step-emoji">⚡</div>
            <div class="step-title">Create a Tunnel</div>
            <div class="step-desc">From your dashboard, create a tunnel and click "Open in App." Your token and tunnel ID auto-fill. Enter your local port and click Start Tunnel.</div>
            <div class="step-code">
                Port: <span class="sc-blue">8000</span><br>
                <span class="sc-green">✓</span> Tunnel connected
            </div>
        </div>

        <div class="step-card" data-scroll>
            <div class="step-num-circle">4</div>
            <div class="step-emoji">🌍</div>
            <div class="step-title">Share Your URL</div>
            <div class="step-desc">Copy your unique public URL and share it with anyone — clients, teammates, or friends. They can access your local project from anywhere in the world.</div>
            <div class="step-code">
                <span class="sc-blue">tunara.dev/t/a8f2k9</span><br>
                <span class="sc-green">✓</span> Accessible worldwide
            </div>
        </div>
    </div>
</section>

<!-- ARCHITECTURE -->
<div class="arch-section">
    <div class="arch-inner">
        <div class="section-tag" style="justify-content:center;">Architecture</div>
        <h2 class="section-title">How the relay works</h2>
        <p class="section-sub" style="margin:0 auto 12px;">A secure WebSocket relay routes requests from the internet to your machine — without opening any ports on your router.</p>

        <div class="arch-diagram">
            <div class="arch-node">
                <div class="arch-node-icon">🌐</div>
                <div class="arch-node-label">Friend's Browser</div>
                <div class="arch-node-sub">Any device, anywhere</div>
            </div>
            <div class="arch-arrow"><div class="arch-line"></div></div>
            <div class="arch-node" style="border-color:rgba(245,197,66,0.25)">
                <div class="arch-node-icon">☁️</div>
                <div class="arch-node-label">Cloudflare</div>
                <div class="arch-node-sub">DNS + CDN</div>
            </div>
            <div class="arch-arrow"><div class="arch-line"></div></div>
            <div class="arch-node" style="border-color:rgba(108,99,255,0.3)">
                <div class="arch-node-icon">🚀</div>
                <div class="arch-node-label">Relay Server</div>
                <div class="arch-node-sub">Tunara on Railway</div>
            </div>
            <div class="arch-arrow"><div class="arch-line"></div></div>
            <div class="arch-node" style="border-color:rgba(56,189,248,0.25)">
                <div class="arch-node-icon">🖥️</div>
                <div class="arch-node-label">Desktop App</div>
                <div class="arch-node-sub">Your computer</div>
            </div>
            <div class="arch-arrow"><div class="arch-line"></div></div>
            <div class="arch-node" style="border-color:rgba(34,211,160,0.25)">
                <div class="arch-node-icon">⚙️</div>
                <div class="arch-node-label">Local Server</div>
                <div class="arch-node-sub">localhost:8000</div>
            </div>
        </div>
    </div>
</div>

<!-- FEATURES -->
<section id="features" class="features-section">
    <div class="section-tag">Features</div>
    <h2 class="section-title">Built for developers</h2>
    <p class="section-sub">Everything you need to share your local project quickly, securely, and reliably.</p>

    <div class="features-grid">
        <div class="feature-card" data-scroll>
            <div class="feature-icon" style="background:rgba(108,99,255,0.1);">⚡</div>
            <div class="feature-title">Instant Setup</div>
            <div class="feature-desc">Go from zero to a public URL in under 60 seconds. No config files, no terminal commands, no router settings. Just click and go.</div>
        </div>
        <div class="feature-card" data-scroll>
            <div class="feature-icon" style="background:rgba(34,211,160,0.1);">🔒</div>
            <div class="feature-title">Secure by Default</div>
            <div class="feature-desc">All tunnels use HTTPS. Token-based authentication ensures only you can control your tunnels. Your system stays safe at all times.</div>
        </div>
        <div class="feature-card" data-scroll>
            <div class="feature-icon" style="background:rgba(56,189,248,0.1);">📊</div>
            <div class="feature-title">Real-time Logs</div>
            <div class="feature-desc">See every request hitting your tunnel live. Method, path, status code, and response time — visible in the desktop app as they happen.</div>
        </div>
        <div class="feature-card" data-scroll>
            <div class="feature-icon" style="background:rgba(251,191,36,0.1);">🌍</div>
            <div class="feature-title">Global Access</div>
            <div class="feature-desc">Share with clients, teammates, or friends across the globe. Any browser, any device — as long as your tunnel is running.</div>
        </div>
        <div class="feature-card" data-scroll>
            <div class="feature-icon" style="background:rgba(255,95,126,0.1);">🎯</div>
            <div class="feature-title">Framework Agnostic</div>
            <div class="feature-desc">Laravel, Next.js, Django, Rails, Express, Vue, React — any framework that runs on localhost. Tunara tunnels it all.</div>
        </div>
        <div class="feature-card" data-scroll>
            <div class="feature-icon" style="background:rgba(167,139,250,0.1);">🔗</div>
            <div class="feature-title">Deep Link Integration</div>
            <div class="feature-desc">Click "Open in App" from your dashboard. Token and Tunnel ID auto-fill in the desktop app. One click to connect, every time.</div>
        </div>
    </div>
</section>

<!-- PRICING -->
<section id="pricing" class="pricing-section">
    <div style="text-align:center;">
        <div class="section-tag" style="justify-content:center;">Pricing</div>
        <h2 class="section-title">Simple, honest pricing</h2>
        <p class="section-sub" style="margin:0 auto;">Start free, upgrade when you need more. No hidden fees, no surprises. Cancel anytime.</p>
    </div>

    <div class="pricing-grid">
        <!-- FREE -->
        <div class="pricing-card">
            <div class="pricing-plan">Free</div>
            <div class="pricing-price"><sup>₹</sup>0<span class="period">/month</span></div>
            <div class="pricing-desc">Perfect for solo developers sharing projects with a client or teammate for review.</div>
            <div class="pricing-divider"></div>
            <div class="pricing-features">
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    {{ $free->max_tunnels ?? 1 }} active tunnel
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    {{ $free->max_requests_per_day == -1 ? 'Unlimited' : number_format($free->max_requests_per_day ?? 1000) }} requests/day
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Secure HTTPS tunnel
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Unlimited viewers
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Real-time request logs
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
                    Priority support
                </div>
            </div>
            <a href="{{ route('register') }}" class="btn btn-ghost pricing-cta">Get Started Free</a>
        </div>

        <!-- PRO -->
        <div class="pricing-card featured">
            <div class="pricing-badge">⭐ Most Popular</div>
            <div class="pricing-plan">Pro</div>
            <div class="pricing-price"><sup>₹</sup>{{ number_format($pro->price ?? 9, 0) }}<span class="period">/month</span></div>
            <div class="pricing-desc">For professionals who need multiple tunnels, custom domains, and advanced security features.</div>
            <div class="pricing-divider"></div>
            <div class="pricing-features">
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    {{ $pro->max_tunnels ?? 5 }} active tunnels
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    {{ $pro->max_requests_per_day == -1 ? 'Unlimited' : number_format($pro->max_requests_per_day) }} requests/day
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Secure HTTPS tunnel
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Unlimited viewers
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Full logs & analytics
                </div>
                <div class="pricing-feature {{ $pro->has_custom_subdomain ? '' : 'dim' }}">
                    <svg class="pfi {{ $pro->has_custom_subdomain ? 'yes' : 'no' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($pro->has_custom_subdomain)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        @endif
                    </svg>
                    Custom subdomain
                </div>
                <div class="pricing-feature {{ $pro->has_password_protection ? '' : 'dim' }}">
                    <svg class="pfi {{ $pro->has_password_protection ? 'yes' : 'no' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($pro->has_password_protection)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        @endif
                    </svg>
                    Password protection
                </div>
                <div class="pricing-feature">
                    <svg class="pfi yes" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Priority support
                </div>
            </div>
            <a href="{{ route('register') }}" class="btn btn-primary pricing-cta">Upgrade to Pro</a>
        </div>
    </div>

    <p style="text-align:center;font-size:13px;color:var(--text-3);margin-top:24px;">All plans include unlimited viewers per tunnel. Pay monthly, cancel anytime.</p>
</section>

<!-- TESTIMONIALS -->
<section class="testimonials-section">
    <div style="text-align:center;">
        <div class="section-tag" style="justify-content:center;">Testimonials</div>
        <h2 class="section-title">Loved by developers</h2>
    </div>
    <div class="testimonials-grid">
        <div class="testimonial-card" data-scroll>
            <div class="testimonial-stars">★★★★★</div>
            <div class="testimonial-text">"Finally an alternative to ngrok that's simple and works great in India. Setup took less than a minute and my client could see my project instantly."</div>
            <div class="testimonial-author">
                <div class="testimonial-avatar">R</div>
                <div>
                    <div class="testimonial-name">Rahul Sharma</div>
                    <div class="testimonial-role">Freelance Developer</div>
                </div>
            </div>
        </div>
        <div class="testimonial-card" data-scroll>
            <div class="testimonial-stars">★★★★★</div>
            <div class="testimonial-text">"The deep link feature is brilliant — one click from the dashboard and everything auto-fills in the app. Saves so much time during demos."</div>
            <div class="testimonial-author">
                <div class="testimonial-avatar">P</div>
                <div>
                    <div class="testimonial-name">Priya Nair</div>
                    <div class="testimonial-role">Full Stack Developer</div>
                </div>
            </div>
        </div>
        <div class="testimonial-card" data-scroll>
            <div class="testimonial-stars">★★★★★</div>
            <div class="testimonial-text">"We use Tunara for showing client work in progress. The real-time logs help us debug issues that only appear in the client's environment."</div>
            <div class="testimonial-author">
                <div class="testimonial-avatar">A</div>
                <div>
                    <div class="testimonial-name">Arjun Mehta</div>
                    <div class="testimonial-role">Tech Lead</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DOWNLOAD -->
<section class="download-section" id="download-app">
    <div class="section-tag" style="justify-content:center;">Desktop App</div>
    <h2 class="section-title" style="text-align:center;">Get Tunara App</h2>
    <p class="section-sub" style="text-align:center;margin:0 auto;">The desktop app connects your local server to the Tunara relay. Lightweight, fast, and always ready.</p>

    <div class="download-card">
        <div class="download-app-icon">🚀</div>
        <div class="download-title">Tunara Desktop</div>
        <div class="download-sub">Available for Windows. macOS version coming soon. Requires the desktop app to activate tunnels.</div>
        <div class="download-btns">
            <a href="https://github.com/mohitsolanki7051/tunara-app/releases/download/v1.0.0/Tunara.Setup.1.0.0.exe" class="download-btn">
                <div class="download-btn-icon">🪟</div>
                <div>
                    <div class="download-btn-label">Download for</div>
                    <div class="download-btn-os">Windows</div>
                </div>
            </a>
        </div>
        <div class="download-version">v1.0.0 · Windows 10 / 11 · 64-bit only</div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="cta-inner">
        <h2 class="cta-title">Ready to go live?</h2>
        <p class="cta-sub">Join developers who use Tunara to share their work with clients and teammates — instantly, securely, and for free.</p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('register') }}" class="btn btn-primary btn-xl">Create Free Account</a>
            <a href="#pricing" class="btn btn-ghost btn-lg">See Pricing</a>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-inner">
        <div class="footer-top">
            <div>
                <div class="footer-brand-name">Tunara</div>
                <div class="footer-brand-desc">A simple, secure localhost tunneling tool built for developers. Share your local project with the world, instantly.</div>
            </div>
            <div>
                <div class="footer-col-title">Product</div>
                <div class="footer-links">
                    <a href="#how-it-works">How it Works</a>
                    <a href="#features">Features</a>
                    <a href="#pricing">Pricing</a>
                    <a href="{{ route('download') }}">Download</a>
                </div>
            </div>
            <div>
                <div class="footer-col-title">Account</div>
                <div class="footer-links">
                    <a href="{{ route('login') }}">Sign In</a>
                    <a href="{{ route('register') }}">Sign Up Free</a>
                    @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ route('settings.index') }}">Settings</a>
                    @endauth
                </div>
            </div>
            <div>
                <div class="footer-col-title">Company</div>
                <div class="footer-links">
                    <a href="#">About</a>
                    <a href="#">Contact</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} Tunara. All rights reserved.</span>
            <span>Made with ❤️ for developers</span>
        </div>
    </div>
</footer>

<script>
    // Intersection observer for scroll animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('[data-scroll], .feature-card, .step-card, .testimonial-card').forEach(el => {
        observer.observe(el);
    });

    // Nav active state on scroll
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-links a');

    window.addEventListener('scroll', () => {
        let current = '';
        sections.forEach(section => {
            if (window.scrollY >= section.offsetTop - 80) {
                current = section.getAttribute('id');
            }
        });
        navLinks.forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href');
            if (href === `#${current}` || (current === '' && href === '{{ route("home") }}')) {
                link.classList.add('active');
            }
        });
    });
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            e.preventDefault();
            const target = document.querySelector(a.getAttribute('href'));
            if (target) target.scrollIntoView({ behavior: 'smooth' });
            history.pushState(null, '', window.location.pathname);
        });
    });
</script>
</body>
</html>

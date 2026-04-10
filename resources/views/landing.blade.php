<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tunara — Instant Localhost Tunneling</title>
    <meta name="description" content="Expose your local server to the internet in seconds. Secure, fast, developer-first tunneling.">
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
        .orb-1 { width: 700px; height: 700px; background: radial-gradient(circle, rgba(91,127,255,0.07) 0%, transparent 70%); top: -200px; right: -200px; animation-delay: 0s; }
        .orb-2 { width: 500px; height: 500px; background: radial-gradient(circle, rgba(34,211,238,0.05) 0%, transparent 70%); bottom: 100px; left: -150px; animation-delay: -7s; }
        .orb-3 { width: 400px; height: 400px; background: radial-gradient(circle, rgba(167,139,250,0.06) 0%, transparent 70%); top: 50%; left: 40%; animation-delay: -14s; }
        @keyframes orbFloat { 0%,100%{transform:translate(0,0) scale(1)} 33%{transform:translate(30px,-40px) scale(1.05)} 66%{transform:translate(-20px,20px) scale(0.95)} }

        .dot-grid { position: fixed; inset: 0; z-index: 0; pointer-events: none; background-image: radial-gradient(circle, rgba(255,255,255,0.04) 1px, transparent 1px); background-size: 28px 28px; mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 40%, transparent 100%); }
        .scanlines { position: fixed; inset: 0; z-index: 1; pointer-events: none; background: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,0,0,0.015) 2px, rgba(0,0,0,0.015) 4px); }

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
        .btn-primary { background: var(--accent); color: white; padding: 8px 18px; font-weight: 600; position: relative; overflow: hidden; }
        .btn-primary::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 50%); opacity: 0; transition: opacity 0.2s; }
        .btn-primary:hover::before { opacity: 1; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(91,127,255,0.35); }
        .btn-xl { padding: 12px 28px; font-size: 14px; border-radius: 10px; font-weight: 600; }

        .hero { position: relative; z-index: 1; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 100px 48px 80px; }
        .hero-eyebrow { display: inline-flex; align-items: center; gap: 8px; font-family: var(--mono); font-size: 11px; font-weight: 500; color: var(--accent); letter-spacing: 0.12em; text-transform: uppercase; margin-bottom: 28px; padding: 5px 14px; border: 1px solid rgba(91,127,255,0.2); border-radius: 100px; background: rgba(91,127,255,0.06); animation: fadeUp 0.6s ease both; }
        .eyebrow-line { width: 16px; height: 1px; background: var(--accent); opacity: 0.6; }
        .hero-headline { font-family: var(--font); font-size: clamp(32px, 5vw, 64px); font-weight: 800; line-height: 1.08; letter-spacing: -0.04em; max-width: 780px; margin-bottom: 20px; animation: fadeUp 0.6s ease 0.1s both; }
        .hl-blue { color: var(--accent); }
        .hero-sub { font-size: 15px; color: var(--text-2); max-width: 460px; line-height: 1.7; margin-bottom: 36px; font-weight: 400; animation: fadeUp 0.6s ease 0.2s both; }
        .hero-cta { display: flex; align-items: center; gap: 12px; margin-bottom: 56px; animation: fadeUp 0.6s ease 0.3s both; }
        .cta-hint { font-family: var(--mono); font-size: 11px; color: var(--text-3); }

        .hero-terminal { width: 100%; max-width: 620px; border-radius: var(--r-lg); overflow: hidden; border: 1px solid var(--border-2); background: var(--bg-2); box-shadow: 0 0 0 1px rgba(91,127,255,0.08), 0 40px 100px rgba(0,0,0,0.8), inset 0 1px 0 rgba(255,255,255,0.05); animation: fadeUp 0.7s ease 0.4s both; position: relative; }
        .hero-terminal::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--accent), transparent); opacity: 0.6; }
        .term-header { padding: 11px 16px; display: flex; align-items: center; gap: 8px; border-bottom: 1px solid var(--border); background: rgba(255,255,255,0.02); }
        .term-dot { width: 10px; height: 10px; border-radius: 50%; }
        .td-r{background:#ff5f57} .td-y{background:#febc2e} .td-g{background:#28c840}
        .term-title { font-family: var(--mono); font-size: 11px; color: var(--text-3); margin-left: auto; }
        .term-status { display: flex; align-items: center; gap: 5px; font-family: var(--mono); font-size: 10px; color: var(--green); }
        .term-status-dot { width: 5px; height: 5px; border-radius: 50%; background: var(--green); animation: pulse 2s infinite; }
        .term-body { padding: 20px; font-family: var(--mono); font-size: 12px; line-height: 1.9; text-align: left; }
        .tl-dim{color:var(--text-3)} .tl-ok{color:var(--green)} .tl-url{color:var(--accent-3);font-weight:500} .tl-path{color:var(--accent-2)} .tl-ms{color:var(--text-3)} .tl-method{color:var(--yellow)} .tl-status{color:var(--green)}
        .cursor-blink { display: inline-block; width: 7px; height: 13px; background: var(--accent); border-radius: 1px; animation: blink 1.1s step-end infinite; vertical-align: middle; }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0} }

        .float-badge { position: absolute; background: var(--bg-3); border: 1px solid var(--border-2); border-radius: 10px; padding: 8px 12px; font-family: var(--mono); font-size: 11px; color: var(--text-2); display: flex; align-items: center; gap: 7px; white-space: nowrap; animation: floatBadge 6s ease-in-out infinite; box-shadow: 0 8px 32px rgba(0,0,0,0.4); }
        .float-badge-dot { width: 6px; height: 6px; border-radius: 50%; }
        .fb-left { left: 170px; top: 30%; animation-delay: 0s; }
        .fb-right { right: 170px; top: 55%; animation-delay: -3s; }
        @keyframes floatBadge { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }

        .stats-strip { position: relative; z-index: 1; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 32px 48px; display: flex; align-items: center; justify-content: center; }
        .stat-item { flex: 1; text-align: center; padding: 0 40px; position: relative; }
        .stat-item + .stat-item::before { content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%); height: 32px; width: 1px; background: var(--border-2); }
        .stat-num { font-family: var(--mono); font-size: 20px; font-weight: 600; color: var(--text); letter-spacing: -0.02em; }
        .stat-label { font-size: 11px; color: var(--text-3); margin-top: 4px; }

        section { position: relative; z-index: 1; }
        .sec-label { font-family: var(--mono); font-size: 10px; font-weight: 500; letter-spacing: 0.15em; text-transform: uppercase; color: var(--accent); margin-bottom: 14px; display: flex; align-items: center; gap: 10px; }
        .sec-label::before { display: none; }
        .sec-title { font-size: clamp(24px, 3vw, 38px); font-weight: 700; letter-spacing: -0.03em; line-height: 1.1; margin-bottom: 14px; }
        .sec-sub { font-size: 14px; color: var(--text-2); line-height: 1.65; max-width: 460px; }

        .how-section { padding: 96px 48px; max-width: 1160px; margin: 0 auto; }
        .how-header { margin-bottom: 56px; }
        .steps-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1px; background: var(--border); border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden; }
        .step-card { background: var(--bg-2); padding: 28px 24px; position: relative; opacity: 0; transform: translateY(16px); transition: opacity 0.5s ease, transform 0.5s ease, background 0.2s; }
        .step-card.vis { opacity: 1; transform: translateY(0); }
        .step-card:nth-child(2){transition-delay:.08s} .step-card:nth-child(3){transition-delay:.16s} .step-card:nth-child(4){transition-delay:.24s}
        .step-card:hover { background: var(--bg-3); }
        .step-num { font-family: var(--mono); font-size: 10px; font-weight: 600; color: var(--accent); letter-spacing: 0.1em; margin-bottom: 16px; opacity: 0.7; }
        .step-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 17px; margin-bottom: 16px; background: var(--bg-4); border: 1px solid var(--border-2); }
        .step-title { font-size: 14px; font-weight: 600; margin-bottom: 8px; letter-spacing: -0.01em; }
        .step-desc { font-size: 12.5px; color: var(--text-2); line-height: 1.65; }
        .step-code { margin-top: 16px; background: var(--bg-4); border: 1px solid var(--border); border-radius: 6px; padding: 10px 12px; font-family: var(--mono); font-size: 10.5px; color: var(--text-2); line-height: 1.7; }
        .sc-green{color:var(--green)} .sc-blue{color:var(--accent-3)}

        .features-section { padding: 96px 48px; max-width: 1160px; margin: 0 auto; }
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1px; background: var(--border); border: 1px solid var(--border); border-radius: var(--r-lg); overflow: hidden; margin-top: 52px; }
        .feat-card { background: var(--bg-2); padding: 26px; position: relative; opacity: 0; transform: translateY(12px); transition: opacity 0.5s ease, transform 0.5s ease, background 0.2s; }
        .feat-card.vis { opacity: 1; transform: translateY(0); }
        .feat-card:nth-child(2){transition-delay:.06s} .feat-card:nth-child(3){transition-delay:.12s} .feat-card:nth-child(4){transition-delay:.06s} .feat-card:nth-child(5){transition-delay:.12s} .feat-card:nth-child(6){transition-delay:.18s}
        .feat-card:hover { background: var(--bg-3); }
        .feat-card::before { content: ''; position: absolute; top: 0; left: 26px; right: 26px; height: 1px; background: linear-gradient(90deg, transparent, var(--accent), transparent); opacity: 0; transition: opacity 0.3s; }
        .feat-card:hover::before { opacity: 0.5; }
        .feat-icon { width: 34px; height: 34px; background: var(--bg-4); border: 1px solid var(--border-2); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 15px; margin-bottom: 14px; }
        .feat-title { font-size: 14px; font-weight: 600; margin-bottom: 7px; letter-spacing: -0.01em; }
        .feat-desc { font-size: 13px; color: var(--text-2); line-height: 1.65; }

        .arch-section { padding: 72px 48px; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); background: linear-gradient(to bottom, rgba(91,127,255,0.02), transparent); position: relative; z-index: 1; }
        .arch-inner { max-width: 960px; margin: 0 auto; text-align: center; }
        .arch-flow { display: flex; align-items: center; justify-content: center; gap: 0; margin-top: 48px; flex-wrap: wrap; }
        .arch-node { background: var(--bg-2); border: 1px solid var(--border-2); border-radius: var(--r); padding: 16px 20px; min-width: 120px; text-align: center; transition: border-color 0.2s, transform 0.2s; }
        .arch-node:hover { border-color: rgba(91,127,255,0.3); transform: translateY(-3px); }
        .arch-node-ico { font-size: 22px; margin-bottom: 7px; }
        .arch-node-name { font-size: 12px; font-weight: 600; }
        .arch-node-sub { font-size: 10px; color: var(--text-3); margin-top: 2px; font-family: var(--mono); }
        .arch-sep { display: flex; align-items: center; padding: 0 10px; }
        .arch-line-wrap { display: flex; flex-direction: column; align-items: center; gap: 3px; }
        .arch-line { width: 32px; height: 1px; background: linear-gradient(90deg, var(--accent), var(--accent-3)); opacity: 0.4; }
        .arch-arrow-ico { font-size: 9px; color: var(--accent); opacity: 0.5; }

        .pricing-section { padding: 96px 48px; max-width: 840px; margin: 0 auto; }
        .pricing-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 44px; }
        .price-card { background: var(--bg-2); border: 1px solid var(--border-2); border-radius: var(--r-lg); padding: 30px; transition: transform 0.3s, border-color 0.3s; }
        .price-card:hover { transform: translateY(-4px); }
        .price-card.pro { border-color: rgba(91,127,255,0.25); background: linear-gradient(135deg, rgba(91,127,255,0.06), rgba(167,139,250,0.02)); position: relative; overflow: hidden; }
        .price-card.pro::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--accent), var(--accent-2), transparent); }
        .price-badge { display: inline-flex; align-items: center; gap: 5px; font-family: var(--mono); font-size: 10px; font-weight: 600; color: var(--accent); background: rgba(91,127,255,0.1); border: 1px solid rgba(91,127,255,0.2); padding: 3px 10px; border-radius: 100px; letter-spacing: 0.08em; text-transform: uppercase; margin-bottom: 18px; }
        .price-plan { font-family: var(--mono); font-size: 11px; font-weight: 500; color: var(--text-3); letter-spacing: 0.12em; text-transform: uppercase; margin-bottom: 8px; }
        .price-amount { font-size: 44px; font-weight: 700; letter-spacing: -0.05em; line-height: 1; margin-bottom: 6px; }
        .price-amount sup { font-size: 18px; font-weight: 500; vertical-align: super; }
        .price-period { font-size: 13px; color: var(--text-3); font-weight: 400; }
        .price-desc { font-size: 13px; color: var(--text-2); margin-bottom: 20px; line-height: 1.6; margin-top: 8px; }
        .price-div { height: 1px; background: var(--border); margin-bottom: 20px; }
        .price-features { display: flex; flex-direction: column; gap: 10px; margin-bottom: 24px; }
        .pf { display: flex; align-items: center; gap: 9px; font-size: 13px; }
        .pf-icon { width: 15px; height: 15px; flex-shrink: 0; }
        .pf-icon.on{color:var(--green)} .pf-icon.off{color:var(--text-3)}
        .pf.muted { color: var(--text-3); }
        .price-btn { width: 100%; padding: 11px; font-size: 13px; font-weight: 600; border-radius: 8px; text-align: center; display: block; }
        .price-btn.outline { border: 1px solid var(--border-2); color: var(--text-2); transition: all 0.2s; }
        .price-btn.outline:hover { border-color: var(--border-3); color: var(--text); background: rgba(255,255,255,0.03); }
        .price-btn.fill { background: var(--accent); color: white; transition: all 0.2s; position: relative; overflow: hidden; }
        .price-btn.fill::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent); opacity: 0; transition: opacity 0.2s; }
        .price-btn.fill:hover::before { opacity: 1; }
        .price-btn.fill:hover { box-shadow: 0 8px 24px rgba(91,127,255,0.35); transform: translateY(-1px); }

        .testimonials-section { padding: 80px 48px; max-width: 1160px; margin: 0 auto; }
        .testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 48px; }
        .testi-card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--r); padding: 22px; opacity: 0; transform: translateY(12px); transition: opacity 0.5s ease, transform 0.5s ease; }
        .testi-card.vis { opacity: 1; transform: translateY(0); }
        .testi-card:nth-child(2){transition-delay:.1s} .testi-card:nth-child(3){transition-delay:.2s}
        .testi-stars { font-size: 12px; color: var(--yellow); margin-bottom: 12px; letter-spacing: 1px; }
        .testi-text { font-size: 13px; color: var(--text-2); line-height: 1.7; margin-bottom: 16px; }
        .testi-author { display: flex; align-items: center; gap: 10px; }
        .testi-avatar { width: 30px; height: 30px; border-radius: 8px; background: linear-gradient(135deg, var(--accent), var(--accent-2)); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: white; font-family: var(--mono); }
        .testi-name { font-size: 13px; font-weight: 600; }
        .testi-role { font-size: 11px; color: var(--text-3); font-family: var(--mono); }

        .download-section { padding: 80px 48px; max-width: 680px; margin: 0 auto; text-align: center; }
        .dl-card { background: var(--bg-2); border: 1px solid var(--border-2); border-radius: 24px; padding: 44px; margin-top: 36px; position: relative; overflow: hidden; }
        .dl-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--accent), var(--accent-3), transparent); }
        .dl-icon { width: 60px; height: 60px; border-radius: 16px; background: linear-gradient(135deg, var(--accent), var(--accent-2)); display: flex; align-items: center; justify-content: center; font-size: 26px; margin: 0 auto 18px; box-shadow: 0 16px 48px rgba(91,127,255,0.3); }
        .dl-title { font-size: 20px; font-weight: 700; letter-spacing: -0.02em; margin-bottom: 8px; }
        .dl-sub { font-size: 13px; color: var(--text-2); line-height: 1.65; margin-bottom: 24px; }
        .dl-btn { display: inline-flex; align-items: center; gap: 12px; background: var(--bg-3); border: 1px solid var(--border-2); border-radius: 10px; padding: 12px 20px; transition: all 0.2s; }
        .dl-btn:hover { border-color: var(--accent); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.3); }
        .dl-btn-ico { font-size: 20px; }
        .dl-btn-label { font-size: 10px; color: var(--text-3); font-family: var(--mono); text-align: left; }
        .dl-btn-os { font-size: 14px; font-weight: 600; }
        .dl-version { font-family: var(--mono); font-size: 11px; color: var(--text-3); margin-top: 16px; }

        .cta-section { padding: 72px 48px; position: relative; z-index: 1; text-align: center; }
        .cta-box { max-width: 580px; margin: 0 auto; background: var(--bg-2); border: 1px solid var(--border-2); border-radius: 24px; padding: 60px 44px; position: relative; overflow: hidden; }
        .cta-box::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, var(--accent), var(--accent-2), transparent); }
        .cta-title { font-size: clamp(22px, 3vw, 34px); font-weight: 700; letter-spacing: -0.03em; margin-bottom: 12px; }
        .cta-sub { font-size: 14px; color: var(--text-2); margin-bottom: 32px; line-height: 1.6; }
        .cta-actions { display: flex; align-items: center; gap: 12px; justify-content: center; }

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

        @media(max-width:768px) {
            body{cursor:auto} .cursor,.cursor-ring{display:none}
            nav{padding:0 20px} .nav-links{display:none}
            .hero{padding:88px 20px 56px}
            .float-badge{display:none}
            .stats-strip{padding:24px 20px;flex-wrap:wrap}
            .stat-item{padding:12px 16px;flex:0 0 50%}
            .stat-item+.stat-item::before{display:none}
            .how-section,.features-section,.pricing-section,.download-section,.testimonials-section{padding:64px 20px}
            .steps-row,.features-grid,.pricing-grid,.testi-grid{grid-template-columns:1fr}
            .arch-flow{gap:8px} .arch-sep{display:none}
            .footer-grid{grid-template-columns:1fr 1fr;gap:28px}
            .cta-box{padding:36px 20px} .cta-actions{flex-direction:column}
        }
    </style>
</head>
<body>

<div class="cursor" id="cursor"></div>
<div class="cursor-ring" id="cursorRing"></div>

<div class="bg-mesh">
    <div class="mesh-orb orb-1"></div>
    <div class="mesh-orb orb-2"></div>
    <div class="mesh-orb orb-3"></div>
</div>
<div class="dot-grid"></div>
<div class="scanlines"></div>

<nav>
    <a href="{{ route('home') }}" class="nav-logo">
        <div class="nav-logo-dot"></div>
        Tunara
    </a>
    <ul class="nav-links">
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="#how-it-works">How it works</a></li>
        <li><a href="#features">Features</a></li>
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

<section class="hero">
    <div class="hero-eyebrow">
        <span class="eyebrow-line"></span>
        Free plan · No credit card required
        <span class="eyebrow-line"></span>
    </div>

    <h1 class="hero-headline">
        Expose localhost to the<br>
        internet <span class="hl-blue">in seconds</span>
    </h1>

    <p class="hero-sub">
        Tunara creates a secure public URL for your local dev server. Share with clients, teammates, or anyone — without touching your router.
    </p>

    <div class="hero-cta">
        <a href="{{ route('register') }}" class="btn btn-primary btn-xl">
            Start for free
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
        </a>
        <a href="{{ route('download') }}" class="btn btn-ghost btn-xl">
            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download
        </a>
        <span class="cta-hint">v1.0.0 · Windows</span>
    </div>

    <div class="hero-terminal" style="position:relative;">
        <div class="float-badge fb-left">
            <div class="float-badge-dot" style="background:var(--green)"></div>
            tunnel active
        </div>
        <div class="float-badge fb-right">
            <div class="float-badge-dot" style="background:var(--accent)"></div>
            websocket connected
        </div>
        <div class="term-header">
            <div class="term-dot td-r"></div>
            <div class="term-dot td-y"></div>
            <div class="term-dot td-g"></div>
            <div class="term-status">
                <div class="term-status-dot"></div>
                live
            </div>
            <span class="term-title">tunara — tunnel/a8f2k9m1</span>
        </div>
        <div class="term-body">
            <div class="tl-dim"># connecting to relay server...</div>
            <div class="tl-ok">✓ token verified</div>
            <div class="tl-ok">✓ tunnel registered</div>
            <div class="tl-ok">✓ websocket ready</div>
            <br>
            <div>public  → <span class="tl-url">https://tunara.online/t/a8f2k9m1</span></div>
            <div class="tl-dim">local   → <span style="color:var(--text-2)">http://localhost:8000</span></div>
            <br>
            <div class="tl-dim">────────────────────────────────</div>
            <div><span class="tl-method">GET</span>  <span class="tl-path">/</span>                <span class="tl-status">200</span>  <span class="tl-ms">18ms</span></div>
            <div><span class="tl-method">GET</span>  <span class="tl-path">/dashboard</span>       <span class="tl-status">200</span>  <span class="tl-ms">22ms</span></div>
            <div><span class="tl-method">POST</span> <span class="tl-path">/api/login</span>       <span class="tl-status">200</span>  <span class="tl-ms">34ms</span></div>
            <div><span class="tl-method">GET</span>  <span class="tl-path">/api/users</span>       <span class="tl-status">200</span>  <span class="tl-ms">29ms</span>  <span class="cursor-blink"></span></div>
        </div>
    </div>
</section>

<div class="stats-strip">
    <div class="stat-item"><div class="stat-num">&lt; 60s</div><div class="stat-label">install to live URL</div></div>
    <div class="stat-item"><div class="stat-num">HTTPS</div><div class="stat-label">secure by default</div></div>
    <div class="stat-item"><div class="stat-num">Free</div><div class="stat-label">no card needed</div></div>
    <div class="stat-item"><div class="stat-num">Any</div><div class="stat-label">framework supported</div></div>
    <div class="stat-item"><div class="stat-num">∞</div><div class="stat-label">viewers per tunnel</div></div>
</div>

<section id="how-it-works" class="how-section">
    <div class="how-header">
        <div class="sec-label">how it works</div>
        <h2 class="sec-title">Live in four steps</h2>
        <p class="sec-sub">From zero to a shareable URL in under a minute. No terminal wizardry required.</p>
    </div>
    <div class="steps-row">
        <div class="step-card" data-anim>
            <div class="step-num">01</div>
            <div class="step-icon">🔐</div>
            <div class="step-title">Create account</div>
            <div class="step-desc">Sign up free. You get a unique auth token that securely links the desktop app to your tunnels.</div>
            <div class="step-code"><span class="sc-green">✓</span> account created<br>token: <span class="sc-blue">a9f2k8...</span></div>
        </div>
        <div class="step-card" data-anim>
            <div class="step-num">02</div>
            <div class="step-icon">📥</div>
            <div class="step-title">Install app</div>
            <div class="step-desc">Download the lightweight Tunara desktop app. It bridges your local server with the internet.</div>
            <div class="step-code"><span class="sc-blue">Tunara-Setup.exe</span><br><span class="sc-green">✓</span> installed & ready</div>
        </div>
        <div class="step-card" data-anim>
            <div class="step-num">03</div>
            <div class="step-icon">⚡</div>
            <div class="step-title">Create tunnel</div>
            <div class="step-desc">Click "New Tunnel" on the dashboard, enter your local port. Token and ID auto-fill in the app.</div>
            <div class="step-code">port: <span class="sc-blue">8000</span><br><span class="sc-green">✓</span> tunnel connected</div>
        </div>
        <div class="step-card" data-anim>
            <div class="step-num">04</div>
            <div class="step-icon">🌍</div>
            <div class="step-title">Share URL</div>
            <div class="step-desc">Copy your public URL and send it. Anyone with the link can access your local project instantly.</div>
            <div class="step-code"><span class="sc-blue">tunara.online/t/a8f2</span><br><span class="sc-green">✓</span> live worldwide</div>
        </div>
    </div>
</section>

<div class="arch-section">
    <div class="arch-inner">
        <div class="sec-label" style="justify-content:center">architecture</div>
        <h2 class="sec-title">How the relay works</h2>
        <p class="sec-sub" style="margin:0 auto 12px">A WebSocket relay routes internet requests to your machine — zero port forwarding needed.</p>
        <div class="arch-flow">
            <div class="arch-node"><div class="arch-node-ico">🌐</div><div class="arch-node-name">Browser</div><div class="arch-node-sub">any device</div></div>
            <div class="arch-sep"><div class="arch-line-wrap"><div class="arch-line"></div><div class="arch-arrow-ico">▶</div></div></div>
            <div class="arch-node" style="border-color:rgba(245,197,66,0.2)"><div class="arch-node-ico">☁️</div><div class="arch-node-name">Cloudflare</div><div class="arch-node-sub">cdn + dns</div></div>
            <div class="arch-sep"><div class="arch-line-wrap"><div class="arch-line"></div><div class="arch-arrow-ico">▶</div></div></div>
            <div class="arch-node" style="border-color:rgba(91,127,255,0.25)"><div class="arch-node-ico">🚀</div><div class="arch-node-name">Relay Server</div><div class="arch-node-sub">railway</div></div>
            <div class="arch-sep"><div class="arch-line-wrap"><div class="arch-line"></div><div class="arch-arrow-ico">▶</div></div></div>
            <div class="arch-node" style="border-color:rgba(34,211,238,0.2)"><div class="arch-node-ico">🖥️</div><div class="arch-node-name">Desktop App</div><div class="arch-node-sub">your machine</div></div>
            <div class="arch-sep"><div class="arch-line-wrap"><div class="arch-line"></div><div class="arch-arrow-ico">▶</div></div></div>
            <div class="arch-node" style="border-color:rgba(16,217,138,0.2)"><div class="arch-node-ico">⚙️</div><div class="arch-node-name">localhost</div><div class="arch-node-sub">:8000</div></div>
        </div>
    </div>
</div>

<section id="features" class="features-section">
    <div class="sec-label">features</div>
    <h2 class="sec-title">Built for developers</h2>
    <p class="sec-sub">Everything you need to share your local project quickly, securely, and reliably.</p>
    <div class="features-grid">
        <div class="feat-card" data-anim><div class="feat-icon">⚡</div><div class="feat-title">Instant setup</div><div class="feat-desc">No config files, no terminal commands, no router settings. Create a tunnel and you're live in under 60 seconds.</div></div>
        <div class="feat-card" data-anim><div class="feat-icon">🔒</div><div class="feat-title">Secure by default</div><div class="feat-desc">All tunnels run over HTTPS. Token-based auth ensures only you control your tunnels.</div></div>
        <div class="feat-card" data-anim><div class="feat-icon">📊</div><div class="feat-title">Real-time logs</div><div class="feat-desc">See every request live — method, path, status, response time — directly in the desktop app.</div></div>
        <div class="feat-card" data-anim><div class="feat-icon">🌍</div><div class="feat-title">Global access</div><div class="feat-desc">Share with clients across the globe. Any browser, any device — as long as your tunnel is running.</div></div>
        <div class="feat-card" data-anim><div class="feat-icon">🎯</div><div class="feat-title">Framework agnostic</div><div class="feat-desc">Laravel, Next.js, Django, Rails, Express, Vue, React — if it runs on localhost, Tunara tunnels it.</div></div>
        <div class="feat-card" data-anim><div class="feat-icon">🔗</div><div class="feat-title">Deep link</div><div class="feat-desc">Click "Open in App" from the dashboard — token and tunnel ID auto-fill. One click to connect.</div></div>
    </div>
</section>

<section id="pricing" class="pricing-section">
    <div style="text-align:center">
        <div class="sec-label" style="justify-content:center">pricing</div>
        <h2 class="sec-title">Simple, honest pricing</h2>
        <p class="sec-sub" style="margin:0 auto">Start free, upgrade when you need more. No hidden fees.</p>
    </div>
    <div class="pricing-grid">
        <div class="price-card">
            <div class="price-plan">Free</div>
            <div class="price-amount"><sup>₹</sup>0<span class="price-period"> /month</span></div>
            <div class="price-desc">Perfect for solo devs sharing with a client or teammate.</div>
            <div class="price-div"></div>
            <div class="price-features">
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>{{ $free->max_tunnels ?? 1 }} active tunnel</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>{{ $free->max_requests_per_day == -1 ? 'Unlimited' : number_format($free->max_requests_per_day ?? 1000) }} requests/day</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Secure HTTPS tunnel</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Unlimited viewers</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Real-time request logs</div>
                <div class="pf {{ $free->has_custom_subdomain ? '' : 'muted' }}"><svg class="pf-icon {{ $free->has_custom_subdomain ? 'on' : 'off' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">@if($free->has_custom_subdomain)<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>@else<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>@endif</svg>Custom subdomain</div>
                <div class="pf {{ $free->has_password_protection ? '' : 'muted' }}"><svg class="pf-icon {{ $free->has_password_protection ? 'on' : 'off' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">@if($free->has_password_protection)<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>@else<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>@endif</svg>Password protection</div>
            </div>
            <a href="{{ route('register') }}" class="price-btn outline">Get started free</a>
        </div>
        <div class="price-card pro">
            <div class="price-badge">⭐ Most popular</div>
            <div class="price-plan">Pro</div>
            <div class="price-amount"><sup>₹</sup>{{ number_format($pro->price ?? 9, 0) }}<span class="price-period"> /month</span></div>
            <div class="price-desc">For professionals who need more tunnels, custom domains, and advanced security.</div>
            <div class="price-div"></div>
            <div class="price-features">
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>{{ $pro->max_tunnels ?? 5 }} active tunnels</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>{{ $pro->max_requests_per_day == -1 ? 'Unlimited' : number_format($pro->max_requests_per_day) }} requests/day</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Secure HTTPS tunnel</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Unlimited viewers</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Full logs & analytics</div>
                <div class="pf {{ $pro->has_custom_subdomain ? '' : 'muted' }}"><svg class="pf-icon {{ $pro->has_custom_subdomain ? 'on' : 'off' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">@if($pro->has_custom_subdomain)<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>@else<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>@endif</svg>Custom subdomain</div>
                <div class="pf {{ $pro->has_password_protection ? '' : 'muted' }}"><svg class="pf-icon {{ $pro->has_password_protection ? 'on' : 'off' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">@if($pro->has_password_protection)<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>@else<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>@endif</svg>Password protection</div>
                <div class="pf"><svg class="pf-icon on" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>Priority support</div>
            </div>
            <a href="{{ route('register') }}" class="price-btn fill">Upgrade to Pro</a>
        </div>
    </div>
    <p style="text-align:center;font-family:var(--mono);font-size:11px;color:var(--text-3);margin-top:18px;">Cancel anytime. No lock-in.</p>
</section>

<section class="testimonials-section">
    <div style="text-align:center">
        <div class="sec-label" style="justify-content:center">testimonials</div>
        <h2 class="sec-title">Loved by developers</h2>
    </div>

    <!-- Dynamic Reviews -->
    @if($reviews->count() > 0)
    <div class="testi-grid">
        @foreach($reviews as $review)
        <div class="testi-card" data-anim>
            <div class="testi-stars">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</div>
            <div class="testi-text">"{{ $review->text }}"</div>
            <div class="testi-author">
                <div class="testi-avatar">{{ strtoupper(substr($review->name, 0, 1)) }}</div>
                <div>
                    <div class="testi-name">{{ $review->name }}</div>
                    @if($review->role)<div class="testi-role">{{ $review->role }}</div>@endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Static fallback jab koi review nahi -->
    <div class="testi-grid">
        <div class="testi-card" data-anim><div class="testi-stars">★★★★★</div><div class="testi-text">"Finally an ngrok alternative that works great in India. Setup under a minute and my client saw my project instantly."</div><div class="testi-author"><div class="testi-avatar">R</div><div><div class="testi-name">Rahul Sharma</div><div class="testi-role">freelance dev</div></div></div></div>
        <div class="testi-card" data-anim><div class="testi-stars">★★★★★</div><div class="testi-text">"The deep link feature is brilliant — one click from the dashboard and everything auto-fills. Saves so much time during demos."</div><div class="testi-author"><div class="testi-avatar">P</div><div><div class="testi-name">Priya Nair</div><div class="testi-role">fullstack dev</div></div></div></div>
        <div class="testi-card" data-anim><div class="testi-stars">★★★★★</div><div class="testi-text">"Real-time logs help us debug issues that only appear in the client's browser. Incredibly useful for demos."</div><div class="testi-author"><div class="testi-avatar">A</div><div><div class="testi-name">Arjun Mehta</div><div class="testi-role">tech lead</div></div></div></div>
    </div>
    @endif

    <!-- Review Submit Form -->
    <div style="max-width:540px;margin:48px auto 0;background:var(--bg-2);border:1px solid var(--border-2);border-radius:var(--r-lg);padding:32px;position:relative;overflow:hidden;">
        <div style="position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--accent),transparent);"></div>
        <div style="text-align:center;margin-bottom:24px;">
            <div style="font-family:var(--mono);font-size:10px;font-weight:500;letter-spacing:0.15em;text-transform:uppercase;color:var(--accent);margin-bottom:8px;">Share your experience</div>
            <h3 style="font-size:18px;font-weight:700;letter-spacing:-0.02em;">Leave a review</h3>
            <p style="font-size:13px;color:var(--text-2);margin-top:6px;">Your feedback helps other developers discover Tunara</p>
        </div>

        @if(session('review_success'))
        <div style="background:rgba(16,217,138,0.08);border:1px solid rgba(16,217,138,0.2);border-radius:8px;padding:14px 16px;text-align:center;margin-bottom:16px;">
            <p style="font-size:13px;color:#10d98a;">{{ session('review_success') }}</p>
        </div>
        @endif

        <form method="POST" action="{{ route('review.submit') }}">
            @csrf
            <!-- Star Rating -->
            <div style="margin-bottom:16px;">
                <label style="font-size:12px;font-weight:500;color:var(--text-2);margin-bottom:8px;display:block;">Rating</label>
                <div style="display:flex;gap:6px;" id="star-container">
                    @for($i=1;$i<=5;$i++)
                    <button type="button" onclick="setRating({{ $i }})" id="star-{{ $i }}"
                        style="font-size:22px;color:var(--text-3);background:none;border:none;cursor:pointer;transition:color 0.15s;padding:0;">★</button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating-input" value="5">
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                <div>
                    <label style="font-size:12px;font-weight:500;color:var(--text-2);margin-bottom:6px;display:block;">Your name *</label>
                    <input type="text" name="name" required placeholder="John Doe" value="{{ old('name') }}"
                        style="width:100%;background:var(--bg-3);border:1px solid var(--border-2);border-radius:8px;padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:var(--font);"
                        onfocus="this.style.borderColor='var(--accent)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                </div>
                <div>
                    <label style="font-size:12px;font-weight:500;color:var(--text-2);margin-bottom:6px;display:block;">Role / Title</label>
                    <input type="text" name="role" placeholder="e.g. Freelance Dev" value="{{ old('role') }}"
                        style="width:100%;background:var(--bg-3);border:1px solid var(--border-2);border-radius:8px;padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:var(--font);"
                        onfocus="this.style.borderColor='var(--accent)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                </div>
            </div>

            <div style="margin-bottom:16px;">
                <label style="font-size:12px;font-weight:500;color:var(--text-2);margin-bottom:6px;display:block;">Your review *</label>
                <textarea name="text" required rows="3" placeholder="Share your experience with Tunara..." maxlength="500"
                    style="width:100%;background:var(--bg-3);border:1px solid var(--border-2);border-radius:8px;padding:9px 12px;font-size:13px;color:var(--text);outline:none;font-family:var(--font);resize:vertical;"
                    onfocus="this.style.borderColor='var(--accent)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">{{ old('text') }}</textarea>
                @error('text')<span style="font-size:11px;color:#ff4d6a;">{{ $message }}</span>@enderror
            </div>

            <button type="submit"
                style="width:100%;padding:11px;background:var(--accent);color:white;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;font-family:var(--font);transition:all 0.2s;"
                onmouseover="this.style.opacity='0.9';this.style.transform='translateY(-1px)'"
                onmouseout="this.style.opacity='1';this.style.transform='translateY(0)'">
                Submit Review
            </button>
        </form>
    </div>
</section>

<section class="download-section" id="download-app">
    <div class="sec-label" style="justify-content:center">desktop app</div>
    <h2 class="sec-title" style="text-align:center">Get Tunara</h2>
    <p class="sec-sub" style="text-align:center;margin:0 auto">The bridge between your local server and the internet.</p>
    <div class="dl-card">
        <div class="dl-icon">🚀</div>
        <div class="dl-title">Tunara Desktop</div>
        <div class="dl-sub">Lightweight, fast, always ready. macOS version coming soon.</div>
        <a href="https://github.com/mohitsolanki7051/tunara-app/releases/download/v1.0.0/Tunara.Setup.1.0.0.exe" class="dl-btn">
            <div class="dl-btn-ico">🪟</div>
            <div><div class="dl-btn-label">Download for</div><div class="dl-btn-os">Windows</div></div>
        </a>
        <div class="dl-version">v1.0.0 · Windows 10/11 · 64-bit</div>
    </div>
</section>

<section class="cta-section">
    <div class="cta-box">
        <h2 class="cta-title">Ready to go live?</h2>
        <p class="cta-sub">Join developers who use Tunara to share work with clients and teammates — instantly and securely.</p>
        <div class="cta-actions">
            <a href="{{ route('register') }}" class="btn btn-primary btn-xl">Create free account</a>
            <a href="{{ route('pricing') }}" class="btn btn-ghost btn-xl">See pricing</a>
        </div>
    </div>
</section>

<footer>
    <div class="footer-inner">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">tunara</div>
                <div class="footer-brand-desc">Simple, secure localhost tunneling for developers. Share your local project with the world.</div>
            </div>
            <div>
                <div class="footer-col-title">Product</div>
                <div class="footer-links">
                    <a href="#how-it-works">How it works</a>
                    <a href="#features">Features</a>
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
                    <a href="{{ route('settings.index') }}">Settings</a>
                    @endauth
                </div>
            </div>
            <div>
                <div class="footer-col-title">Company</div>
                <div class="footer-links">
                    <a href="#">About</a>
                    <a href="#">Contact</a>
                    <a href="#">Privacy</a>
                    <a href="#">Terms</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© {{ date('Y') }} tunara. all rights reserved.</span>
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
    rx += (mx - rx) * 0.12;
    ry += (my - ry) * 0.12;
    ring.style.left = rx - 16 + 'px';
    ring.style.top = ry - 16 + 'px';
    requestAnimationFrame(animRing);
}
animRing();
document.querySelectorAll('a, button').forEach(el => {
    el.addEventListener('mouseenter', () => { cursor.style.transform='scale(2.5)'; ring.style.transform='scale(1.5)'; ring.style.borderColor='rgba(91,127,255,0.6)'; });
    el.addEventListener('mouseleave', () => { cursor.style.transform='scale(1)'; ring.style.transform='scale(1)'; ring.style.borderColor='rgba(91,127,255,0.4)'; });
});
const obs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('vis'); });
}, { threshold: 0.1 });
document.querySelectorAll('[data-anim], .feat-card, .step-card, .testi-card').forEach(el => obs.observe(el));
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const target = document.querySelector(a.getAttribute('href'));
        if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth' }); history.pushState(null, '', window.location.pathname); }
    });
});

function setRating(val) {
    document.getElementById('rating-input').value = val;
    for(let i=1;i<=5;i++) {
        document.getElementById('star-'+i).style.color = i <= val ? '#fbbf24' : 'var(--text-3)';
    }
}
setRating(5); // Default 5 stars
</script>
</body>
</html>

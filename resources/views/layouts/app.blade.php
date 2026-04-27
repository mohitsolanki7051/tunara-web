<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tunara') — Local to Public</title>
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #07090f;
            --bg-2: #0d1018;
            --bg-3: #13161f;
            --bg-4: #1a1e2a;
            --border: rgba(255,255,255,0.07);
            --border-2: rgba(255,255,255,0.12);
            --text: #eef2ff;
            --text-2: #7d8aa0;
            --text-3: #3d4558;
            --accent: #5b7fff;
            --accent-2: #a78bfa;
            --accent-glow: rgba(91,127,255,0.18);
            --green: #20d4a0;
            --red: #ff5f7e;
            --radius: 12px;
            --radius-sm: 8px;
            --font: 'DM Sans', system-ui, sans-serif;
            --mono: 'DM Mono', monospace;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font); background: var(--bg); color: var(--text); min-height: 100vh; line-height: 1.6; -webkit-font-smoothing: antialiased; }
        a { color: inherit; text-decoration: none; }
        button { font-family: var(--font); cursor: pointer; border: none; background: none; }
        input { font-family: var(--font); }

        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 20px; border-radius: var(--radius-sm); font-size: 14px; font-weight: 500; transition: all 0.18s; cursor: pointer; border: none; white-space: nowrap; }
        .btn-primary { background: linear-gradient(135deg, var(--accent), var(--accent-2)); color: white; }
        .btn-primary:hover { opacity: 0.88; transform: translateY(-1px); box-shadow: 0 8px 24px rgba(91,127,255,0.3); }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary:disabled { opacity: 0.4; cursor: not-allowed; transform: none; box-shadow: none; }
        .btn-ghost { background: transparent; color: var(--text-2); border: 1px solid var(--border); }
        .btn-ghost:hover { border-color: var(--border-2); color: var(--text); }
        .btn-sm { padding: 7px 14px; font-size: 13px; }
        .btn-xs { padding: 5px 11px; font-size: 12px; }

        .input { width: 100%; background: var(--bg-3); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 11px 14px; color: var(--text); font-size: 14px; transition: all 0.18s; }
        .input::placeholder { color: var(--text-3); }
        .input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow); }

        .card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); }

        .grad { background: linear-gradient(135deg, var(--accent), var(--accent-2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .grad-bg { background: linear-gradient(135deg, var(--accent), var(--accent-2)); }

        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 9px; border-radius: 20px; font-size: 11px; font-weight: 500; letter-spacing: 0.02em; }
        .badge-green { background: rgba(32,212,160,0.1); color: var(--green); }
        .badge-gray { background: rgba(255,255,255,0.05); color: var(--text-3); }

        .dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .dot-green { background: var(--green); animation: pulse 2s infinite; }
        .dot-gray { background: var(--text-3); }
        @keyframes pulse { 0%,100% { opacity:1; } 50% { opacity:0.3; } }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--bg-4); border-radius: 2px; }

        #toast { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: none; background: var(--bg-3); border: 1px solid var(--border-2); color: var(--text); padding: 11px 16px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 500; box-shadow: 0 8px 32px rgba(0,0,0,0.5); animation: toastIn 0.25s ease; }
        @keyframes toastIn { from { opacity:0; transform: translateY(6px); } to { opacity:1; transform: translateY(0); } }

        label { display: block; font-size: 13px; font-weight: 500; color: var(--text-2); margin-bottom: 6px; }

        .form-group { display: flex; flex-direction: column; gap: 4px; }
        .hint { font-size: 12px; color: var(--text-3); }

        .error-box { background: rgba(255,95,126,0.08); border: 1px solid rgba(255,95,126,0.2); border-radius: var(--radius-sm); padding: 10px 14px; }
        .error-box p { font-size: 13px; color: var(--red); }
    </style>
    @yield('head')
</head>
<body>
    @yield('content')
    <div id="toast"></div>
    <script>
        function showToast(msg, type = 'success') {
            const t = document.getElementById('toast');
            t.textContent = (type === 'success' ? '✓  ' : '✕  ') + msg;
            t.style.display = 'block';
            t.style.borderColor = type === 'success' ? 'rgba(32,212,160,0.25)' : 'rgba(255,95,126,0.25)';
            clearTimeout(window._toastTimer);
            window._toastTimer = setTimeout(() => t.style.display = 'none', 3000);
        }
    </script>
    @yield('scripts')
</body>
</html>

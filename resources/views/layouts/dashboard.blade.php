<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Tunara</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #07090f;
            --bg-2: #0d1018;
            --bg-3: #13161f;
            --bg-4: #1a1e2a;
            --sidebar: #0a0c14;
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
            --sidebar-w: 228px;
            --header-h: 52px;
            --font: 'DM Sans', system-ui, sans-serif;
            --mono: 'DM Mono', monospace;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: var(--font); background: var(--bg); color: var(--text); min-height: 100vh; line-height: 1.6; -webkit-font-smoothing: antialiased; display: flex; }
        a { color: inherit; text-decoration: none; }
        button { font-family: var(--font); cursor: pointer; border: none; background: none; }
        input { font-family: var(--font); }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--sidebar);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 50;
        }

        .sidebar-logo {
            padding: 20px 20px 16px;
            border-bottom: 1px solid var(--border);
        }
        .sidebar-logo a { font-size: 18px; font-weight: 700; background: linear-gradient(135deg, var(--accent), var(--accent-2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .sidebar-logo span { display: block; font-size: 11px; color: var(--text-3); margin-top: 1px; }

        .sidebar-nav { flex: 1; padding: 12px 10px; display: flex; flex-direction: column; gap: 2px; }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text-3);
            transition: all 0.15s;
        }
        .nav-link:hover { background: rgba(255,255,255,0.04); color: var(--text-2); }
        .nav-link.active { background: rgba(91,127,255,0.1); color: var(--accent); }
        .nav-link svg { width: 15px; height: 15px; flex-shrink: 0; }

        .sidebar-download {
            margin: 0 10px 10px;
            background: var(--bg-3);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px;
        }
        .sidebar-download p:first-child { font-size: 12px; font-weight: 600; color: var(--text-2); margin-bottom: 3px; }
        .sidebar-download p:last-of-type { font-size: 11px; color: var(--text-3); margin-bottom: 10px; }
        .download-btn { width: 100%; padding: 8px; border-radius: var(--radius-sm); background: linear-gradient(135deg, var(--accent), var(--accent-2)); color: white; font-size: 12px; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 6px; cursor: pointer; border: none; font-family: var(--font); transition: opacity 0.15s; }
        .download-btn:hover { opacity: 0.88; }
        .download-btn svg { width: 12px; height: 12px; }

        .sidebar-user {
            padding: 12px 16px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-avatar {
            width: 30px; height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; flex-shrink: 0;
        }
        .user-info { flex: 1; min-width: 0; }
        .user-info p:first-child { font-size: 13px; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-info p:last-child { font-size: 11px; color: var(--text-3); }
        .logout-btn { color: var(--text-3); transition: color 0.15s; flex-shrink: 0; }
        .logout-btn:hover { color: var(--text-2); }
        .logout-btn svg { width: 15px; height: 15px; display: block; }

        /* ── Main ── */
        .main { flex: 1; margin-left: var(--sidebar-w); display: flex; flex-direction: column; min-height: 100vh; }

        .topbar {
            height: var(--header-h);
            border-bottom: 1px solid var(--border);
            background: rgba(7,9,15,0.8);
            backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 15px;
            z-index: 30;
        }
        .topbar-title { font-size: 14px; font-weight: 600; }
        .topbar-sub { font-size: 12px; color: var(--text-3); margin-top: 1px; }

        .page-content { flex: 1; padding: 28px; }

        /* ── UI Components ── */
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 9px 18px; border-radius: var(--radius-sm); font-size: 13.5px; font-weight: 500; transition: all 0.18s; cursor: pointer; border: none; white-space: nowrap; font-family: var(--font); }
        .btn-primary { background: linear-gradient(135deg, var(--accent), var(--accent-2)); color: white; }
        .btn-primary:hover { opacity: 0.88; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(91,127,255,0.28); }
        .btn-primary:active { transform: translateY(0); }
        .btn-primary:disabled { opacity: 0.38; cursor: not-allowed; transform: none; box-shadow: none; }
        .btn-ghost { background: transparent; color: var(--text-2); border: 1px solid var(--border); }
        .btn-ghost:hover { border-color: var(--border-2); color: var(--text); }
        .btn-sm { padding: 6px 13px; font-size: 12.5px; }
        .btn-xs { padding: 4px 10px; font-size: 12px; border-radius: 6px; }

        .input { width: 100%; background: var(--bg-3); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 10px 14px; color: var(--text); font-size: 14px; transition: all 0.18s; font-family: var(--font); }
        .input::placeholder { color: var(--text-3); }
        .input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow); }

        .card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); }

        .grad { background: linear-gradient(135deg, var(--accent), var(--accent-2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .grad-bg { background: linear-gradient(135deg, var(--accent), var(--accent-2)); }

        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 500; }
        .badge-green { background: rgba(32,212,160,0.1); color: var(--green); }
        .badge-gray { background: rgba(255,255,255,0.05); color: var(--text-3); }

        .dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .dot-green { background: var(--green); animation: blink 2s infinite; }
        .dot-gray { background: var(--text-3); }
        @keyframes blink { 0%,100% { opacity:1; } 50% { opacity:0.3; } }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed; inset: 0; z-index: 100;
            background: rgba(0,0,0,0.72);
            backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .modal-overlay.open { display: flex; }
        .modal {
            background: var(--bg-2);
            border: 1px solid var(--border-2);
            border-radius: 16px;
            width: 100%;
            max-width: 440px;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalIn 0.22s ease;
        }
        @keyframes modalIn { from { opacity:0; transform: scale(0.97) translateY(8px); } to { opacity:1; transform: scale(1) translateY(0); } }
        .modal-header { padding: 20px 22px 16px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--border); }
        .modal-header h3 { font-size: 15px; font-weight: 600; }
        .modal-close { color: var(--text-3); transition: color 0.15s; padding: 2px; }
        .modal-close:hover { color: var(--text); }
        .modal-close svg { width: 18px; height: 18px; display: block; }
        .modal-body { padding: 20px 22px; }
        .modal-footer { padding: 16px 22px; display: flex; gap: 10px; border-top: 1px solid var(--border); }
        .modal-footer .btn { flex: 1; }

        label { display: block; font-size: 13px; font-weight: 500; color: var(--text-2); margin-bottom: 6px; }
        .hint { font-size: 12px; color: var(--text-3); margin-top: 5px; }
        .error-box { background: rgba(255,95,126,0.08); border: 1px solid rgba(255,95,126,0.2); border-radius: var(--radius-sm); padding: 10px 14px; }
        .error-box p { font-size: 13px; color: var(--red); }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--bg-4); border-radius: 2px; }

        #toast { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: none; background: var(--bg-3); border: 1px solid var(--border-2); color: var(--text); padding: 11px 16px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 500; box-shadow: 0 8px 32px rgba(0,0,0,0.5); }
    </style>
    @yield('head')
</head>
<body>

{{-- Sidebar --}}
<aside class="sidebar">
    <div class="sidebar-logo">
        <a href="/">Tunara</a>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            Dashboard
        </a>
        {{-- <a href="{{ route('tunnels.index') }}" class="nav-link {{ request()->routeIs('tunnels.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Tunnels
        </a> --}}
        <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Settings
        </a>
    </nav>

    <div class="sidebar-download">
        <p>Desktop App</p>
        <p>Required to activate tunnels</p>
        <button class="download-btn">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download for Windows
        </button>
    </div>

    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div class="user-info">
            <p>{{ Auth::user()->name }}</p>
            <p>Free Plan</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn" title="Logout">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            </button>
        </form>
    </div>
</aside>

{{-- Main --}}
<div class="main">
    <header class="topbar">
        <div>
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            <div class="topbar-sub">@yield('page-subtitle', '')</div>
        </div>
        <div>@yield('header-actions')</div>
    </header>

    <main class="page-content">
        @yield('content')
    </main>
</div>

<div id="toast"></div>

<script>
    function showToast(msg, type = 'success') {
        const t = document.getElementById('toast');
        t.textContent = (type === 'success' ? '✓  ' : '✕  ') + msg;
        t.style.display = 'block';
        t.style.borderColor = type === 'success' ? 'rgba(32,212,160,0.25)' : 'rgba(255,95,126,0.25)';
        clearTimeout(window._tt);
        window._tt = setTimeout(() => t.style.display = 'none', 3000);
    }
</script>

@yield('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Tunara</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #07090f;
            --bg-2: #0d1018;
            --bg-3: #13161f;
            --bg-4: #1a1e2a;
            --sidebar: #09090f;
            --border: rgba(255,255,255,0.07);
            --border-2: rgba(255,255,255,0.12);
            --text: #eef2ff;
            --text-2: #7d8aa0;
            --text-3: #3d4558;
            --accent: #5b7fff;
            --accent-2: #a78bfa;
            --green: #20d4a0;
            --red: #ff5f7e;
            --yellow: #f5c542;
            --radius: 12px;
            --radius-sm: 8px;
            --sidebar-w: 220px;
            --font: 'DM Sans', system-ui, sans-serif;
            --mono: 'DM Mono', monospace;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--font); background: var(--bg); color: var(--text); min-height: 100vh; display: flex; -webkit-font-smoothing: antialiased; }
        a { color: inherit; text-decoration: none; }
        button { font-family: var(--font); cursor: pointer; border: none; background: none; }

        .sidebar { width: var(--sidebar-w); background: var(--sidebar); border-right: 1px solid var(--border); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 50; }
        .sidebar-logo { padding: 20px; border-bottom: 1px solid var(--border); }
        .sidebar-logo-text { font-size: 17px; font-weight: 700; background: linear-gradient(135deg, var(--accent), var(--accent-2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .sidebar-logo-badge { display: inline-block; background: rgba(255,95,126,0.1); border: 1px solid rgba(255,95,126,0.2); border-radius: 20px; padding: 2px 8px; font-size: 10px; color: var(--red); margin-top: 4px; font-weight: 600; letter-spacing: 0.05em; }

        .sidebar-nav { flex: 1; padding: 12px 10px; display: flex; flex-direction: column; gap: 2px; }
        .nav-link { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: var(--radius-sm); font-size: 13.5px; font-weight: 500; color: var(--text-3); transition: all 0.15s; }
        .nav-link:hover { background: rgba(255,255,255,0.04); color: var(--text-2); }
        .nav-link.active { background: rgba(91,127,255,0.1); color: var(--accent); }
        .nav-link svg { width: 15px; height: 15px; flex-shrink: 0; }

        .sidebar-footer { padding: 12px 16px; border-top: 1px solid var(--border); }
        .admin-info { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .admin-avatar { width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, var(--red), #ff8c69); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; }
        .admin-name { font-size: 13px; font-weight: 500; }
        .admin-role { font-size: 11px; color: var(--text-3); }
        .logout-btn { width: 100%; padding: 8px; border-radius: var(--radius-sm); border: 1px solid var(--border); color: var(--text-3); font-size: 12.5px; font-weight: 500; display: flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.15s; cursor: pointer; background: none; font-family: var(--font); }
        .logout-btn:hover { border-color: var(--border-2); color: var(--text-2); }
        .logout-btn svg { width: 14px; height: 14px; }

        .main { flex: 1; margin-left: var(--sidebar-w); display: flex; flex-direction: column; }
        .topbar { height: 52px; border-bottom: 1px solid var(--border); background: rgba(7,9,15,0.8); backdrop-filter: blur(12px); display: flex; align-items: center; justify-content: space-between; padding: 0 28px; position: sticky; top: 0; z-index: 30; }
        .topbar-title { font-size: 14px; font-weight: 600; }
        .topbar-sub { font-size: 12px; color: var(--text-3); margin-top: 1px; }
        .page-content { flex: 1; padding: 28px; }

        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 9px 18px; border-radius: var(--radius-sm); font-size: 13.5px; font-weight: 500; transition: all 0.18s; cursor: pointer; border: none; font-family: var(--font); }
        .btn-primary { background: linear-gradient(135deg, var(--accent), var(--accent-2)); color: white; }
        .btn-primary:hover { opacity: 0.88; transform: translateY(-1px); }
        .btn-ghost { background: transparent; color: var(--text-2); border: 1px solid var(--border); }
        .btn-ghost:hover { border-color: var(--border-2); color: var(--text); }
        .btn-danger { background: rgba(255,95,126,0.1); color: var(--red); border: 1px solid rgba(255,95,126,0.25); }
        .btn-danger:hover { background: rgba(255,95,126,0.18); }
        .btn-sm { padding: 6px 13px; font-size: 12.5px; }
        .btn-xs { padding: 4px 10px; font-size: 12px; border-radius: 6px; }

        .input { width: 100%; background: var(--bg-3); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 10px 14px; color: var(--text); font-size: 14px; font-family: var(--font); transition: all 0.18s; }
        .input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(91,127,255,0.18); }
        .input::placeholder { color: var(--text-3); }

        .card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); }

        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 2px 8px; border-radius: 20px; font-size: 11px; font-weight: 500; }
        .badge-green { background: rgba(32,212,160,0.1); color: var(--green); }
        .badge-blue { background: rgba(91,127,255,0.1); color: var(--accent); }
        .badge-red { background: rgba(255,95,126,0.1); color: var(--red); }
        .badge-gray { background: rgba(255,255,255,0.05); color: var(--text-3); }

        .modal-overlay { position: fixed; inset: 0; z-index: 200; background: rgba(0,0,0,0.75); backdrop-filter: blur(8px); display: none; align-items: center; justify-content: center; padding: 16px; }
        .modal-overlay.open { display: flex; }
        .modal-box { background: var(--bg-2); border: 1px solid var(--border-2); border-radius: 16px; width: 100%; max-width: 420px; overflow: hidden; animation: mIn 0.22s ease; }
        @keyframes mIn { from { opacity:0; transform: scale(0.96) translateY(10px); } to { opacity:1; transform: scale(1) translateY(0); } }
        .modal-head { padding: 18px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .modal-head h3 { font-size: 15px; font-weight: 600; }
        .modal-head button { color: var(--text-3); transition: color 0.15s; }
        .modal-head button:hover { color: var(--text); }
        .modal-head button svg { width: 18px; height: 18px; display: block; }
        .modal-body { padding: 20px; }
        .modal-foot { padding: 16px 20px; border-top: 1px solid var(--border); display: flex; gap: 10px; }
        .modal-foot .btn { flex: 1; }

        label { display: block; font-size: 13px; font-weight: 500; color: var(--text-2); margin-bottom: 6px; }
        .form-group { display: flex; flex-direction: column; gap: 4px; margin-bottom: 16px; }
        .hint { font-size: 12px; color: var(--text-3); }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--bg-4); border-radius: 2px; }

        #toast { position: fixed; bottom: 24px; right: 24px; z-index: 9999; display: none; background: var(--bg-3); border: 1px solid var(--border-2); color: var(--text); padding: 11px 16px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 500; box-shadow: 0 8px 32px rgba(0,0,0,0.5); }

        .alert-success { background: rgba(32,212,160,0.08); border: 1px solid rgba(32,212,160,0.2); border-radius: var(--radius-sm); padding: 12px 16px; font-size: 13px; color: var(--green); margin-bottom: 20px; }
    </style>
    @yield('head')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-text">Tunara</div>
        <div class="sidebar-logo-badge">ADMIN</div>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Users
        </a>
        <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Plan Settings
        </a>
        <a href="{{ route('admin.reviews') }}" class="nav-link {{ request()->routeIs('admin.reviews') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Reviews
        </a>
        <a href="{{ route('home') }}" class="nav-link" target="_blank">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            View Website
        </a>
        <a href="{{ route('admin.pages.index') }}" class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Pages
        </a>
        <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Contact Messages
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="admin-info">
            <div class="admin-avatar">A</div>
            <div>
                <div class="admin-name">{{ session('admin_name', 'Admin') }}</div>
                <div class="admin-role">Super Admin</div>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>

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

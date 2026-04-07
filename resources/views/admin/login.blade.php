<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Tunara</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #07090f;
            --bg-2: #0d1018;
            --bg-3: #13161f;
            --border: rgba(255,255,255,0.07);
            --border-2: rgba(255,255,255,0.12);
            --text: #eef2ff;
            --text-2: #7d8aa0;
            --text-3: #3d4558;
            --accent: #5b7fff;
            --accent-2: #a78bfa;
            --accent-glow: rgba(91,127,255,0.18);
            --red: #ff5f7e;
            --radius: 12px;
            --radius-sm: 8px;
            --font: 'DM Sans', system-ui, sans-serif;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--font); background: var(--bg); color: var(--text); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; -webkit-font-smoothing: antialiased; }

        .wrap { width: 100%; max-width: 380px; }

        .logo { text-align: center; margin-bottom: 32px; }
        .logo-text { font-size: 22px; font-weight: 700; background: linear-gradient(135deg, var(--accent), var(--accent-2)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .logo-badge { display: inline-block; background: rgba(91,127,255,0.1); border: 1px solid rgba(91,127,255,0.2); border-radius: 20px; padding: 3px 10px; font-size: 11px; color: var(--accent); margin-top: 6px; font-weight: 500; }

        .card { background: var(--bg-2); border: 1px solid var(--border); border-radius: 16px; padding: 28px; }
        .card h1 { font-size: 20px; font-weight: 700; margin-bottom: 6px; }
        .card > p { font-size: 13px; color: var(--text-2); margin-bottom: 24px; }

        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: 13px; font-weight: 500; color: var(--text-2); margin-bottom: 6px; }
        input { width: 100%; background: var(--bg-3); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 10px 14px; color: var(--text); font-size: 14px; font-family: var(--font); transition: all 0.18s; }
        input::placeholder { color: var(--text-3); }
        input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-glow); }

        .btn { width: 100%; padding: 11px; border-radius: var(--radius-sm); background: linear-gradient(135deg, var(--accent), var(--accent-2)); color: white; font-size: 14px; font-weight: 600; border: none; cursor: pointer; font-family: var(--font); transition: all 0.18s; margin-top: 4px; }
        .btn:hover { opacity: 0.88; transform: translateY(-1px); }

        .error-box { background: rgba(255,95,126,0.08); border: 1px solid rgba(255,95,126,0.2); border-radius: var(--radius-sm); padding: 10px 14px; margin-bottom: 16px; }
        .error-box p { font-size: 13px; color: var(--red); }

        .back-link { text-align: center; margin-top: 20px; font-size: 13px; color: var(--text-3); }
        .back-link a { color: var(--accent); }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="logo">
            <div class="logo-text">Tunara</div>
            <div class="logo-badge">Admin Panel</div>
        </div>

        <div class="card">
            <h1>Admin Login</h1>
            <p>Sign in to manage your Tunara instance</p>

            @if($errors->any())
            <div class="error-box">
                @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="form-group">
                    <label>Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@tunara.dev" required autofocus>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn">Sign in to Admin</button>
            </form>
        </div>

        <div class="back-link">
            <a href="{{ route('home') }}">← Back to website</a>
        </div>
    </div>
</body>
</html>

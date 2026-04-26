@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Manage your tunnels and activity')

@section('header-actions')
@if($tunnels->count() >= $maxTunnels)
<button class="btn btn-ghost btn-sm" disabled style="opacity:0.5;cursor:not-allowed;" title="Tunnel limit reached">
    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Limit Reached
</button>
@else
<button class="btn btn-primary btn-sm" onclick="openCreateModal()">
    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    New Tunnel
</button>
@endif
@endsection

@section('head')
<style>
    .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
    .stat { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px 22px; }
    .stat-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
    .stat-label { font-size: 13px; color: var(--text-2); }
    .stat-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    .stat-icon svg { width: 15px; height: 15px; }
    .stat-icon-blue { background: rgba(91,127,255,0.12); color: var(--accent); }
    .stat-icon-green { background: rgba(32,212,160,0.1); color: var(--green); }
    .stat-icon-purple { background: rgba(167,139,250,0.1); color: var(--accent-2); }
    .stat-value { font-size: 28px; font-weight: 700; letter-spacing: -0.02em; }
    .stat-sub { font-size: 12px; color: var(--text-3); margin-top: 3px; }
    .stat-sub a { color: var(--accent); }

    .token-card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px 22px; margin-bottom: 24px; }
    .token-card-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 14px; }
    .token-card-top h2 { font-size: 14px; font-weight: 600; }
    .token-card-top p { font-size: 12px; color: var(--text-3); margin-top: 3px; }
    .token-field { display: flex; align-items: center; gap: 10px; background: var(--bg-3); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 10px 14px; }
    .token-field svg { width: 14px; height: 14px; color: var(--text-3); flex-shrink: 0; }
    .token-val { font-family: var(--mono); font-size: 13px; color: var(--text-2); flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .icon-btn { color: var(--text-3); transition: color 0.15s; padding: 2px; flex-shrink: 0; background: none; border: none; cursor: pointer; }
    .icon-btn:hover { color: var(--text); }
    .icon-btn svg { width: 15px; height: 15px; display: block; }

    .tunnels-card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .tunnels-header { padding: 16px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
    .tunnels-header h2 { font-size: 14px; font-weight: 600; }
    .tunnels-header button { font-size: 12px; color: var(--accent); background: none; border: none; cursor: pointer; font-family: var(--font); transition: opacity 0.15s; }
    .tunnels-header button:hover { opacity: 0.75; }

    .empty-state { padding: 60px 20px; text-align: center; }
    .empty-icon { width: 52px; height: 52px; background: var(--bg-3); border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
    .empty-icon svg { width: 24px; height: 24px; color: var(--text-3); }
    .empty-state h3 { font-size: 15px; font-weight: 600; margin-bottom: 6px; }
    .empty-state p { font-size: 13px; color: var(--text-2); margin-bottom: 20px; }

    .tunnel-row { display: flex; align-items: center; gap: 14px; padding: 14px 22px; border-bottom: 1px solid var(--border); transition: background 0.15s; }
    .tunnel-row:last-child { border-bottom: none; }
    .tunnel-row:hover { background: rgba(255,255,255,0.02); }
    .tunnel-info { flex: 1; min-width: 0; }
    .tunnel-meta { display: flex; align-items: center; gap: 8px; margin-bottom: 4px; }
    .tunnel-url { font-family: var(--mono); font-size: 12.5px; color: var(--accent); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .tunnel-local { font-size: 12px; color: var(--text-3); margin-top: 3px; }
    .tunnel-actions { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }

    .pagination { display: flex; align-items: center; padding: 14px 22px; border-top: 1px solid var(--border); gap: 8px; }
    .pagination-info { font-size: 12px; color: var(--text-3); flex: 1; }
    .pagination-btns { display: flex; align-items: center; gap: 4px; }
    .page-btn { width: 30px; height: 30px; border-radius: 6px; border: 1px solid var(--border); background: none; color: var(--text-2); font-size: 12px; font-weight: 500; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.15s; font-family: var(--font); }
    .page-btn:hover:not(:disabled) { border-color: var(--border-2); color: var(--text); }
    .page-btn.active { background: linear-gradient(135deg, var(--accent), var(--accent-2)); border-color: transparent; color: white; }
    .page-btn:disabled { opacity: 0.35; cursor: not-allowed; }
    .page-btn svg { width: 12px; height: 12px; }

    .open-app-btn { display: inline-flex; align-items: center; gap: 5px; padding: 5px 11px; border-radius: 6px; font-size: 12px; font-weight: 500; background: rgba(91,127,255,0.1); color: var(--accent); border: 1px solid rgba(91,127,255,0.2); cursor: pointer; font-family: var(--font); transition: all 0.15s; text-decoration: none; }
    .open-app-btn:hover { background: rgba(91,127,255,0.18); }
    .open-app-btn svg { width: 11px; height: 11px; }

    /* Plan limit banner */
    .limit-banner { background: rgba(245,197,66,0.08); border: 1px solid rgba(245,197,66,0.2); border-radius: var(--radius-sm); padding: 12px 16px; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; }
    .limit-banner p { font-size: 13px; color: #f5c542; flex: 1; }
    .limit-banner a { font-size: 13px; font-weight: 600; color: #f5c542; border: 1px solid rgba(245,197,66,0.3); padding: 5px 12px; border-radius: 6px; white-space: nowrap; }
    .limit-banner a:hover { background: rgba(245,197,66,0.1); }

    .modal-overlay { position: fixed; inset: 0; z-index: 200; background: rgba(0,0,0,0.75); backdrop-filter: blur(8px); display: none; align-items: center; justify-content: center; padding: 16px; }
    .modal-overlay.open { display: flex; }
    .modal-box { background: var(--bg-2); border: 1px solid var(--border-2); border-radius: 16px; width: 100%; max-width: 420px; overflow: hidden; animation: mIn 0.22s ease; }
    .modal-box.modal-app { max-width: 500px; max-height: 80vh; overflow-y: auto; }
    @keyframes mIn { from { opacity:0; transform: scale(0.96) translateY(10px); } to { opacity:1; transform: scale(1) translateY(0); } }
    .modal-head { padding: 18px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
    .modal-head h3 { font-size: 15px; font-weight: 600; }
    .modal-head button { color: var(--text-3); transition: color 0.15s; background: none; border: none; cursor: pointer; }
    .modal-head button:hover { color: var(--text); }
    .modal-head button svg { width: 18px; height: 18px; display: block; }
    .modal-body { padding: 20px; }
    .modal-foot { padding: 16px 20px; border-top: 1px solid var(--border); display: flex; gap: 10px; }
    .modal-foot .btn { flex: 1; }

    .app-modal-hero { text-align: center; padding: 24px 20px 18px; }
    .app-modal-icon { width: 56px; height: 56px; border-radius: 16px; background: linear-gradient(135deg, var(--accent), var(--accent-2)); display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; }
    .app-modal-icon svg { width: 28px; height: 28px; color: white; }
    .app-modal-hero p { font-size: 13px; color: var(--text-2); }

    .url-display { background: var(--bg-3); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 10px 14px; display: flex; align-items: center; gap: 10px; margin: 16px 20px; }
    .url-display-label { font-size: 11px; color: var(--text-3); white-space: nowrap; }
    .url-display-val { font-family: var(--mono); font-size: 12px; color: var(--accent); flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    .app-steps { padding: 0 20px 16px; }
    .app-steps-title { font-size: 11px; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--text-3); margin-bottom: 12px; }
    .app-step { display: flex; align-items: flex-start; gap: 12px; padding: 8px 0; }
    .app-step + .app-step { border-top: 1px solid var(--border); }
    .app-step-num { width: 22px; height: 22px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), var(--accent-2)); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: white; flex-shrink: 0; margin-top: 1px; }
    .app-step-text p:first-child { font-size: 13px; font-weight: 500; }
    .app-step-text p:last-child { font-size: 12px; color: var(--text-3); }

    .app-modal-actions { padding: 16px 20px; border-top: 1px solid var(--border); display: flex; flex-direction: column; gap: 8px; }
    .app-modal-actions .btn-primary { width: 100%; padding: 11px; font-size: 14px; font-weight: 600; }
    .download-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .download-row a { display: flex; align-items: center; justify-content: center; gap: 6px; padding: 9px; border: 1px solid var(--border); border-radius: var(--radius-sm); font-size: 12.5px; color: var(--text-2); transition: all 0.15s; text-decoration: none; }
    .download-row a:hover { border-color: var(--border-2); color: var(--text); }
    .later-btn { background: none; border: none; font-family: var(--font); font-size: 13px; color: var(--text-3); cursor: pointer; text-align: center; padding: 6px; transition: color 0.15s; }
    .later-btn:hover { color: var(--text-2); }

    .browser-tip { background: rgba(91,127,255,0.06); border: 1px solid rgba(91,127,255,0.15); border-radius: var(--radius-sm); padding: 10px 14px; margin: 0 20px 16px; display: flex; gap: 10px; align-items: flex-start; }
    .browser-tip-icon { font-size: 14px; flex-shrink: 0; margin-top: 1px; }
    .browser-tip p { font-size: 12px; color: var(--text-2); line-height: 1.5; }
    .browser-tip strong { color: var(--text); }

    .btn-danger { background: rgba(255,95,126,0.1); color: var(--red); border: 1px solid rgba(255,95,126,0.25); }
    .btn-danger:hover { background: rgba(255,95,126,0.18); }

    @keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection

@section('content')
{{-- Server Warning --}}
@if(!$serverConnected)
<div style="background:rgba(255,95,126,0.08);border:1px solid rgba(255,95,126,0.2);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:12px;">
    <span style="font-size:18px;">🔴</span>
    <p style="font-size:13px;color:var(--red);">Unable to connect to Tunara server. Please check your network connection and try again.</p>
</div>
@endif
{{-- Limit Banner --}}
@if($tunnels->count() >= $maxTunnels && $userPlan === 'free')
<div class="limit-banner">
    <span style="font-size:18px;">⚠️</span>
    <p>You've reached your free plan limit of <strong>{{ $maxTunnels }} tunnel</strong>. Delete existing tunnel or upgrade to Pro for more.</p>
    <button onclick="openComingSoon()" style="font-size:13px;font-weight:600;color:#f5c542;border:1px solid rgba(245,197,66,0.3);padding:5px 12px;border-radius:6px;white-space:nowrap;background:none;cursor:pointer;font-family:var(--font);">Upgrade to Pro</button>
</div>
@endif

<div class="stats">
    <div class="stat">
        <div class="stat-top">
            <span class="stat-label">Total Tunnels</span>
            <div class="stat-icon stat-icon-blue">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </div>
        <div class="stat-value" id="total-count">{{ $tunnels->count() }}</div>
        <div class="stat-sub">{{ $tunnels->count() }}/{{ $maxTunnels }} used on {{ ucfirst($userPlan) }} plan</div>
    </div>
    <div class="stat">
        <div class="stat-top">
            <span class="stat-label">Active Now</span>
            <div class="stat-icon stat-icon-green">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="stat-value" id="active-count">—</div>
        <div class="stat-sub">tunnels currently running</div>
    </div>
    <div class="stat">
        <div class="stat-top">
            <span class="stat-label">Current Plan</span>
            <div class="stat-icon stat-icon-purple">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
        </div>
        <div class="stat-value">{{ ucfirst($userPlan) }}</div>
        <div class="stat-sub">
            @if($userPlan === 'free')
                <button onclick="openComingSoon()" style="color:var(--accent);background:none;border:none;cursor:pointer;font-size:12px;font-family:var(--font);">Upgrade to Pro →</button>
            @else
                Pro plan active
            @endif
        </div>
    </div>
</div>

<div class="token-card">
    <div class="token-card-top">
        <div>
            <h2>Auth Token</h2>
            <p>Paste this in the Tunara desktop app to connect</p>
        </div>
    </div>
    <div class="token-field">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
        <span class="token-val" id="token-display">{{ substr($token->token, 0, 8) }}••••••••••••••••••••••••</span>
        <button class="icon-btn" onclick="toggleToken()" title="Show/Hide">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        </button>
        <button class="icon-btn" onclick="copyToken()" title="Copy">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
        </button>
    </div>
</div>

<div class="tunnels-card">
    <div class="tunnels-header">
        <h2>Your Tunnels</h2>
        @if($tunnels->count() < $maxTunnels)
        <button onclick="openCreateModal()">+ Create New</button>
        @endif
    </div>

    @if($tunnels->isEmpty())
    <div class="empty-state" id="empty-state">
        <div class="empty-icon">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <h3>No tunnels yet</h3>
        <p>Create your first tunnel to start sharing your local project</p>
        <button class="btn btn-primary btn-sm" onclick="openCreateModal()">Create Tunnel</button>
    </div>
    @else
    <div id="tunnels-list">
        @foreach($tunnels as $tunnel)
        <div class="tunnel-row" id="tunnel-row-{{ $tunnel->tunnel_id }}">
            <div class="tunnel-info">
                <div class="tunnel-meta">
                    <span class="badge badge-gray" id="badge-{{ $tunnel->tunnel_id }}">
                        <span class="dot dot-gray" id="dot-{{ $tunnel->tunnel_id }}"></span>
                        <span id="badge-text-{{ $tunnel->tunnel_id }}">Inactive</span>
                    </span>
                    <span style="font-size:12px;color:var(--text-3)">{{ $tunnel->created_at->diffForHumans() }}</span>
                </div>
                <div class="tunnel-url">{{ env('CLOUDFLARE_WORKER_URL') }}/t/{{ $tunnel->tunnel_id }}</div>
                <div class="tunnel-local">{{ $tunnel->local_url }}</div>
            </div>
            <div class="tunnel-actions">
                <a href="tunara://connect?token={{ $token->token }}&tunnelId={{ $tunnel->tunnel_id }}&port={{ parse_url($tunnel->local_url, PHP_URL_PORT) ?? 8000 }}" class="open-app-btn" onclick="setTimeout(closeAppModal, 800)">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Open in App
                </a>
                <button class="icon-btn" onclick="copyTunnelUrl('{{ env('CLOUDFLARE_WORKER_URL') }}/t/{{ $tunnel->tunnel_id }}')" title="Copy URL">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </button>
                <button class="icon-btn" onclick="deleteTunnel('{{ $tunnel->tunnel_id }}')" title="Delete" style="color:var(--text-3)">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="pagination" id="pagination" style="display:none;">
        <span class="pagination-info" id="pagination-info"></span>
        <div class="pagination-btns" id="pagination-btns"></div>
    </div>
</div>

{{-- CREATE MODAL --}}
<div class="modal-overlay" id="create-modal">
    <div class="modal-box">
        <div class="modal-head">
            <h3>Create New Tunnel</h3>
            <button onclick="closeCreateModal()"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="modal-url">Local Project URL</label>
                <input class="input" type="url" id="modal-url" placeholder="http://localhost:8000">
                <p class="hint">Enter the URL where your local server is running</p>
            </div>

            @if(($userPlan ?? 'free') === 'pro' && ($planSetting->has_password_protection ?? false))
            <div class="form-group" style="margin-top:14px;">
                <label for="modal-password">Password Protection <span style="font-size:11px;color:var(--accent-2);">Pro</span></label>
                <input class="input" type="password" id="modal-password" placeholder="Leave empty for no password">
                <p class="hint">Optional — viewers will need this password to access your tunnel</p>
            </div>
            @endif

            <div id="modal-error" class="error-box" style="display:none;margin-top:12px;">
                <p id="modal-error-msg"></p>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="closeCreateModal()">Cancel</button>
            <button class="btn btn-primary" id="modal-create-btn" onclick="createTunnel()">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Generate URL
            </button>
        </div>
    </div>
</div>

{{-- APP MODAL --}}
<div class="modal-overlay" id="app-modal">
    <div class="modal-box modal-app">
        <div class="modal-head">
            <h3>Tunnel Ready! 🎉</h3>
            <button onclick="closeAppModal()"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="app-modal-hero" style="padding:16px 20px 4px;">
            <div class="app-modal-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <p>Your public URL is ready. Activate it with the desktop app.</p>
        </div>

        <div class="url-display">
            <span class="url-display-label">Public URL</span>
            <span class="url-display-val" id="app-modal-url"></span>
            <button class="icon-btn" onclick="copyModalUrl()">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            </button>
        </div>

        <div class="browser-tip">
            <span class="browser-tip-icon">💡</span>
            <p>When browser asks <strong>"Open Electron?"</strong> — click <strong>Open Electron</strong> and check <strong>"Always allow"</strong> to skip next time.</p>
        </div>

        <div class="app-steps">
            <div class="app-steps-title">How to activate</div>
            @foreach([
                ['t' => 'Download & install Tunara app', 's' => 'One-time setup only'],
                ['t' => 'Click "Open in Tunara App" below', 's' => 'Token & Tunnel ID auto-fill'],
                ['t' => 'Click "Start Tunnel" in the app', 's' => 'URL goes live instantly'],
                ['t' => 'Share the public URL with anyone', 's' => 'Works from any browser or device'],
            ] as $i => $step)
            <div class="app-step">
                <div class="app-step-num">{{ $i + 1 }}</div>
                <div class="app-step-text">
                    <p>{{ $step['t'] }}</p>
                    <p>{{ $step['s'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="app-modal-actions">
            <a id="app-modal-deeplink" href="#" class="btn btn-primary" onclick="setTimeout(closeAppModal, 800)">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Open in Tunara App
            </a>
            {{-- <div class="download-row">
               <a href="https://github.com/mohitsolanki7051/tunara-app/releases/download/v1.0.0/Tunara.Setup.1.0.0.exe">🪟 Windows</a>

            </div> --}}
            <button class="later-btn" onclick="closeAppModal()">I'll do this later</button>
        </div>
    </div>
</div>

{{-- DELETE MODAL --}}
<div class="modal-overlay" id="delete-modal">
    <div class="modal-box" style="max-width:380px;">
        <div class="modal-head">
            <h3>Delete Tunnel</h3>
            <button onclick="closeDeleteModal()"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="modal-body">
            <p style="font-size:14px;color:var(--text-2);line-height:1.6;">Are you sure you want to delete this tunnel? This cannot be undone.</p>
            <div style="background:var(--bg-3);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 14px;margin-top:12px;">
                <p style="font-family:var(--mono);font-size:12px;color:var(--text-3);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" id="delete-tunnel-url"></p>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="closeDeleteModal()">Cancel</button>
            <button class="btn btn-danger" id="delete-confirm-btn" onclick="confirmDelete()">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Delete Tunnel
            </button>
        </div>
    </div>
</div>
<!-- Coming Soon Modal -->
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
@endsection

@section('scripts')
<script>
    const TOKEN = '{{ $token->token }}';
    const MAX_TUNNELS = {{ $maxTunnels }};
    let tokenVisible = false;
    let currentPublicUrl = '';
    let pendingDeleteId = null;
    const PER_PAGE = 10;
    let currentPage = 1;

    function toggleToken() {
        tokenVisible = !tokenVisible;
        document.getElementById('token-display').textContent = tokenVisible ? TOKEN : TOKEN.substring(0, 8) + '••••••••••••••••••••••••';
    }
    function copyToken() {
        navigator.clipboard.writeText(TOKEN);
        showToast('Token copied!');
    }

    function openCreateModal() {
        document.getElementById('create-modal').classList.add('open');
        document.getElementById('modal-url').value = '';
        document.getElementById('modal-error').style.display = 'none';
        setTimeout(() => document.getElementById('modal-url').focus(), 100);
    }
    function closeCreateModal() {
        document.getElementById('create-modal').classList.remove('open');
    }

    function openAppModal(url, tunnelId, port) {
        currentPublicUrl = url;
        document.getElementById('app-modal-url').textContent = url;
        document.getElementById('app-modal-deeplink').href = `tunara://connect?token=${TOKEN}&tunnelId=${tunnelId}&port=${port}`;
        document.getElementById('app-modal').classList.add('open');
    }
    function closeAppModal() {
        document.getElementById('app-modal').classList.remove('open');
    }
    function copyModalUrl() {
        navigator.clipboard.writeText(currentPublicUrl);
        showToast('URL copied!');
    }

    function deleteTunnel(tunnelId) {
        pendingDeleteId = tunnelId;
        const row = document.getElementById(`tunnel-row-${tunnelId}`);
        const url = row?.querySelector('.tunnel-url')?.textContent || tunnelId;
        document.getElementById('delete-tunnel-url').textContent = url;
        document.getElementById('delete-modal').classList.add('open');
    }
    function closeDeleteModal() {
        pendingDeleteId = null;
        document.getElementById('delete-modal').classList.remove('open');
    }
    async function confirmDelete() {
        if (!pendingDeleteId) return;
        const tunnelId = pendingDeleteId;
        const btn = document.getElementById('delete-confirm-btn');
        btn.disabled = true;
        btn.textContent = 'Deleting...';
        try {
            const res = await fetch(`/tunnel/${tunnelId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (data.success) {
                closeDeleteModal();
                document.getElementById(`tunnel-row-${tunnelId}`)?.remove();
                showToast('Tunnel deleted!');


                const totalEl = document.getElementById('total-count');
                const oldCount = totalEl ? parseInt(totalEl.textContent) : 1;
                const newCount = oldCount - 1;
                if (totalEl) totalEl.textContent = newCount;


                const statSub = totalEl?.closest('.stat')?.querySelector('.stat-sub');
                if (statSub) statSub.textContent = `${newCount}/${MAX_TUNNELS} used on {{ ucfirst($userPlan) }} plan`;

                refreshPagination();


                if (newCount < MAX_TUNNELS) {
                    const banner = document.querySelector('.limit-banner');
                    if (banner) banner.style.display = 'none';


                    const limitBtn = document.querySelector('.topbar button[disabled]');
                    if (limitBtn) {
                        limitBtn.disabled = false;
                        limitBtn.style.opacity = '1';
                        limitBtn.style.cursor = 'pointer';
                        limitBtn.innerHTML = `<svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> New Tunnel`;
                        limitBtn.onclick = openCreateModal;
                        limitBtn.className = 'btn btn-primary btn-sm';
                    }


                    const tunnelsHeader = document.querySelector('.tunnels-header');
                    if (tunnelsHeader && !tunnelsHeader.querySelector('button')) {
                        const createBtn = document.createElement('button');
                        createBtn.textContent = '+ Create New';
                        createBtn.onclick = openCreateModal;
                        tunnelsHeader.appendChild(createBtn);
                    }
                }


                const remaining = document.querySelectorAll('#tunnels-list .tunnel-row').length;
                if (remaining === 0) {
                    const list = document.getElementById('tunnels-list');
                    if (list) list.innerHTML = `
                        <div class="empty-state">
                            <div class="empty-icon"><svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
                            <h3>No tunnels yet</h3>
                            <p>Create your first tunnel to start sharing your local project</p>
                            <button class="btn btn-primary btn-sm" onclick="openCreateModal()">Create Tunnel</button>
                        </div>`;
                }
            }
        } catch(e) {
            showToast('Failed to delete', 'error');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg> Delete Tunnel';
        }
    }

    function refreshPagination() {
        const rows = Array.from(document.querySelectorAll('#tunnels-list .tunnel-row'));
        const total = rows.length;
        const paginationEl = document.getElementById('pagination');
        if (!paginationEl) return;
        if (total <= PER_PAGE) {
            paginationEl.style.display = 'none';
            rows.forEach(r => r.style.display = 'flex');
            return;
        }
        paginationEl.style.display = 'flex';
        const totalPages = Math.ceil(total / PER_PAGE);
        if (currentPage > totalPages) currentPage = totalPages;
        renderPage(currentPage);
    }

    function renderPage(page) {
        currentPage = page;
        const rows = Array.from(document.querySelectorAll('#tunnels-list .tunnel-row'));
        const total = rows.length;
        const totalPages = Math.ceil(total / PER_PAGE);
        rows.forEach((row, i) => {
            row.style.display = (i >= (page-1)*PER_PAGE && i < page*PER_PAGE) ? 'flex' : 'none';
        });
        const start = (page-1)*PER_PAGE + 1;
        const end = Math.min(page*PER_PAGE, total);
        const infoEl = document.getElementById('pagination-info');
        if (infoEl) infoEl.textContent = `Showing ${start}–${end} of ${total} tunnels`;
        renderBtns(page, totalPages);
    }

    function renderBtns(page, totalPages) {
        const c = document.getElementById('pagination-btns');
        if (!c) return;
        c.innerHTML = '';
        const prev = document.createElement('button');
        prev.className = 'page-btn';
        prev.innerHTML = '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>';
        prev.disabled = page === 1;
        prev.onclick = () => renderPage(page - 1);
        c.appendChild(prev);
        for (let i = 1; i <= totalPages; i++) {
            if (totalPages > 7 && i > 2 && i < totalPages - 1 && Math.abs(i - page) > 1) {
                if (i === 3 || i === totalPages - 2) {
                    const dots = document.createElement('button');
                    dots.className = 'page-btn';
                    dots.textContent = '...';
                    dots.disabled = true;
                    c.appendChild(dots);
                }
                continue;
            }
            const btn = document.createElement('button');
            btn.className = 'page-btn' + (i === page ? ' active' : '');
            btn.textContent = i;
            btn.onclick = () => renderPage(i);
            c.appendChild(btn);
        }
        const next = document.createElement('button');
        next.className = 'page-btn';
        next.innerHTML = '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>';
        next.disabled = page === totalPages;
        next.onclick = () => renderPage(page + 1);
        c.appendChild(next);
    }

    async function createTunnel() {
        const localUrl = document.getElementById('modal-url').value.trim();
        const password = document.getElementById('modal-password')?.value.trim() || '';
        const btn = document.getElementById('modal-create-btn');
        const errDiv = document.getElementById('modal-error');
        if (!localUrl) { document.getElementById('modal-url').focus(); return; }
        btn.disabled = true;
        btn.innerHTML = '<svg width="14" height="14" style="animation:spin 0.7s linear infinite" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" opacity="0.3"/><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.37 0 0 5.37 0 12h4z"/></svg> Generating...';
        errDiv.style.display = 'none';
        try {
            const res = await fetch('{{ route("tunnel.register") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ local_url: localUrl, password: password || null })
            });
            const data = await res.json();
            if (data.success) {
                closeCreateModal();
                addTunnelRow(data.tunnel_id, localUrl, data.public_url, data.port);
                openAppModal(data.public_url, data.tunnel_id, data.port);


                const totalEl = document.getElementById('total-count');
                const newCount = totalEl ? parseInt(totalEl.textContent) + 1 : 1;
                if (totalEl) totalEl.textContent = newCount;


                const statSub = totalEl?.closest('.stat')?.querySelector('.stat-sub');
                if (statSub) statSub.textContent = `${newCount}/${MAX_TUNNELS} used on {{ ucfirst($userPlan) }} plan`;


                if (newCount >= MAX_TUNNELS) {
                    const newBtn = document.querySelector('.topbar button.btn-primary');
                    if (newBtn) {
                        newBtn.disabled = true;
                        newBtn.style.opacity = '0.5';
                        newBtn.style.cursor = 'not-allowed';
                        newBtn.innerHTML = `<svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Limit Reached`;
                        newBtn.onclick = null;
                        newBtn.className = 'btn btn-ghost btn-sm';
                    }

                    const tunnelsHeader = document.querySelector('.tunnels-header button');
                    if (tunnelsHeader) tunnelsHeader.remove();
                }
            } else {
                throw new Error(data.message || 'Failed to create tunnel');
            }
        } catch (e) {
            document.getElementById('modal-error-msg').textContent = e.message;
            errDiv.style.display = 'block';
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg> Generate URL';
        }
    }

    function addTunnelRow(tunnelId, localUrl, publicUrl, port) {
        const empty = document.querySelector('.empty-state');
        if (empty) empty.remove();
        let list = document.getElementById('tunnels-list');
        if (!list) {
            list = document.createElement('div');
            list.id = 'tunnels-list';
            document.querySelector('.tunnels-card').insertBefore(list, document.getElementById('pagination'));
        }
        const deepLink = `tunara://connect?token=${TOKEN}&tunnelId=${tunnelId}&port=${port}`;
        const row = document.createElement('div');
        row.className = 'tunnel-row';
        row.id = `tunnel-row-${tunnelId}`;
        row.innerHTML = `
            <div class="tunnel-info">
                <div class="tunnel-meta">
                    <span class="badge badge-gray" id="badge-${tunnelId}"><span class="dot dot-gray" id="dot-${tunnelId}"></span><span id="badge-text-${tunnelId}">Inactive</span></span>
                    <span style="font-size:12px;color:var(--text-3)">just now</span>
                </div>
                <div class="tunnel-url">${publicUrl}</div>
                <div class="tunnel-local">${localUrl}</div>
            </div>
            <div class="tunnel-actions">
                <a href="${deepLink}" class="open-app-btn" onclick="setTimeout(closeAppModal,800)">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Open in App
                </a>
                <button class="icon-btn" onclick="copyTunnelUrl('${publicUrl}')">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </button>
                <button class="icon-btn" onclick="deleteTunnel('${tunnelId}')" style="color:var(--text-3)">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </div>`;
        list.prepend(row);
        refreshPagination();
    }

    function updateNewTunnelBtn(currentCount) {
        const headerActions = document.querySelector('[data-header-actions]') ||
            document.querySelector('.topbar > div:last-child');


        if (currentCount < MAX_TUNNELS) {

            const limitBtn = document.querySelector('.topbar button[disabled]');
            if (limitBtn) {
                limitBtn.disabled = false;
                limitBtn.style.opacity = '1';
                limitBtn.style.cursor = 'pointer';
                limitBtn.innerHTML = `<svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> New Tunnel`;
                limitBtn.onclick = openCreateModal;
                limitBtn.className = 'btn btn-primary btn-sm';
            }

            const banner = document.querySelector('.limit-banner');
            if (banner) banner.style.display = 'none';
        }
    }

    function copyTunnelUrl(url) {
        navigator.clipboard.writeText(url);
        showToast('URL copied!');
    }

    async function checkActiveTunnels() {
        const tunnelIds = [
            @foreach($tunnels as $tunnel) '{{ $tunnel->tunnel_id }}', @endforeach
        ];
        let active = 0;
        for (const id of tunnelIds) {
            try {
                const res = await fetch(`{{ env('RAILWAY_SERVER_URL') }}/api/tunnel/status/${id}`);
                if (res.ok) {
                    const d = await res.json();
                    const badge = document.getElementById(`badge-${id}`);
                    const dot = document.getElementById(`dot-${id}`);
                    const txt = document.getElementById(`badge-text-${id}`);
                    if (d.isOnline) {
                        active++;
                        if (badge) badge.className = 'badge badge-green';
                        if (dot) dot.className = 'dot dot-green';
                        if (txt) txt.textContent = 'Active';
                    } else {
                        if (badge) badge.className = 'badge badge-gray';
                        if (dot) dot.className = 'dot dot-gray';
                        if (txt) txt.textContent = 'Inactive';
                    }
                }
            } catch(e) {}
        }
        const el = document.getElementById('active-count');
        if (el) el.textContent = active;
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('modal-url')?.addEventListener('keydown', e => { if (e.key === 'Enter') createTunnel(); });
        checkActiveTunnels();
        setInterval(checkActiveTunnels, 10000);
        refreshPagination();
    });

    function openComingSoon() {
    document.getElementById('coming-soon-modal').style.display = 'flex';
    }
    function closeComingSoon() {
        document.getElementById('coming-soon-modal').style.display = 'none';
    }
</script>
@endsection

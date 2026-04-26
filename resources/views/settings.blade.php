@extends('layouts.dashboard')
@section('title', 'Settings')
@section('page-title', 'Settings')
@section('page-subtitle', 'Manage your account and preferences')

@section('head')
<style>
    .settings-grid { display: flex; flex-direction: column; gap: 20px; }

    .settings-card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .settings-card-head { padding: 18px 24px; border-bottom: 1px solid var(--border); }
    .settings-card-head h2 { font-size: 14px; font-weight: 600; }
    .settings-card-head p { font-size: 12px; color: var(--text-3); margin-top: 3px; }
    .settings-card-body { padding: 24px; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
    .form-group:last-of-type { margin-bottom: 0; }
    .form-group label { font-size: 13px; font-weight: 500; color: var(--text-2); }
    .form-group .hint { font-size: 12px; color: var(--text-3); }

    .alert { padding: 10px 14px; border-radius: var(--radius-sm); font-size: 13px; margin-bottom: 16px; }
    .alert-success { background: rgba(32,212,160,0.08); border: 1px solid rgba(32,212,160,0.2); color: var(--green); }
    .alert-error { background: rgba(255,95,126,0.08); border: 1px solid rgba(255,95,126,0.2); color: var(--red); }

    .form-footer { display: flex; justify-content: flex-end; margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border); }

    .token-display-row { display: flex; align-items: center; gap: 10px; background: var(--bg-3); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 10px 14px; margin-bottom: 16px; }
    .token-display-row svg { width: 14px; height: 14px; color: var(--text-3); flex-shrink: 0; }
    .token-display-val { font-family: var(--mono); font-size: 13px; color: var(--text-2); flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .icon-btn { color: var(--text-3); transition: color 0.15s; padding: 2px; flex-shrink: 0; background: none; border: none; cursor: pointer; }
    .icon-btn:hover { color: var(--text); }
    .icon-btn svg { width: 15px; height: 15px; display: block; }

    .danger-zone { border-color: rgba(255,95,126,0.2); }
    .danger-zone .settings-card-head { border-bottom-color: rgba(255,95,126,0.15); }
    .danger-zone .settings-card-head h2 { color: var(--red); }
    .btn-danger { background: rgba(255,95,126,0.15) !important; color: var(--red) !important; border: 1px solid rgba(255,95,126,0.4) !important; }
    .btn-danger:hover:not(:disabled) { background: rgba(255,95,126,0.25) !important; }
    .btn-danger:disabled { opacity: 0.4; cursor: not-allowed; }

    .danger-input-row { display: flex; align-items: center; gap: 12px; }
    .danger-input-row .input { flex: 1; }

    .plan-info { display: flex; align-items: center; justify-content: space-between; background: var(--bg-3); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 14px 18px; }
    .plan-info-left h3 { font-size: 15px; font-weight: 700; }
    .plan-info-left p { font-size: 12px; color: var(--text-3); margin-top: 3px; }
    .plan-features { display: flex; flex-direction: column; gap: 6px; margin-top: 16px; }
    .plan-feature { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-2); }
    .plan-feature svg { width: 14px; height: 14px; color: var(--green); flex-shrink: 0; }
    .plan-feature.disabled { color: var(--text-3); }
    .plan-feature.disabled svg { color: var(--text-3); }

    /* Modals */
    .modal-overlay { position: fixed; inset: 0; z-index: 200; background: rgba(0,0,0,0.75); backdrop-filter: blur(8px); display: none; align-items: center; justify-content: center; padding: 16px; }
    .modal-overlay.open { display: flex; }
    .modal-box { background: var(--bg-2); border: 1px solid var(--border-2); border-radius: 16px; width: 100%; max-width: 420px; overflow: hidden; animation: mIn 0.22s ease; }
    @keyframes mIn { from { opacity:0; transform: scale(0.96) translateY(10px); } to { opacity:1; transform: scale(1) translateY(0); } }
    .modal-head { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
    .modal-head h3 { font-size: 15px; font-weight: 600; }
    .modal-head button { color: var(--text-3); transition: color 0.15s; background: none; border: none; cursor: pointer; }
    .modal-head button:hover { color: var(--text); }
    .modal-head button svg { width: 18px; height: 18px; display: block; }
    .modal-body { padding: 22px; }
    .modal-foot { padding: 16px 22px; border-top: 1px solid var(--border); display: flex; gap: 10px; }
    .modal-foot .btn { flex: 1; }
    .modal-foot form { flex: 1; }
    .modal-foot form .btn { width: 100%; }
    .modal-warn { background: rgba(245,197,66,0.08); border: 1px solid rgba(245,197,66,0.2); border-radius: var(--radius-sm); padding: 12px 14px; margin-top: 14px; }
    .modal-warn p { font-size: 13px; color: #f5c542; line-height: 1.5; }
    .modal-danger-info { background: rgba(255,95,126,0.08); border: 1px solid rgba(255,95,126,0.2); border-radius: var(--radius-sm); padding: 12px 14px; margin-top: 14px; }
    .modal-danger-info p { font-size: 13px; color: var(--red); line-height: 1.5; }
</style>
@endsection

@section('content')
<div class="settings-grid">

    {{-- Profile --}}
    <div class="settings-card">
        <div class="settings-card-head">
            <h2>Profile</h2>
            <p>Update your name and email address</p>
        </div>
        <div class="settings-card-body">
            @if(session('success_profile'))
            <div class="alert alert-success">✓ {{ session('success_profile') }}</div>
            @endif
            @if($errors->has('name') || $errors->has('email'))
            <div class="alert alert-error">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('settings.profile') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input class="input" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input class="input" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Password --}}
    <div class="settings-card">
        <div class="settings-card-head">
            <h2>Change Password</h2>
            <p>Update your account password</p>
        </div>
        <div class="settings-card-body">
            @if(session('success_password'))
            <div class="alert alert-success">✓ {{ session('success_password') }}</div>
            @endif
            @if($errors->has('current_password'))
            <div class="alert alert-error">{{ $errors->first('current_password') }}</div>
            @endif

            <form method="POST" action="{{ route('settings.password') }}">
                @csrf
                <div class="form-group">
                    <label>Current Password</label>
                    <input class="input" type="password" name="current_password" placeholder="••••••••" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>New Password</label>
                        <input class="input" type="password" name="password" placeholder="Min. 8 characters" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input class="input" type="password" name="password_confirmation" placeholder="Repeat password" required>
                    </div>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Update Password</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Auth Token --}}
    <div class="settings-card">
        <div class="settings-card-head">
            <h2>Auth Token</h2>
            <p>Used to authenticate the Tunara desktop app</p>
        </div>
        <div class="settings-card-body">
            @if(session('success_token'))
            <div class="alert alert-success">✓ {{ session('success_token') }}</div>
            @endif

            <div class="token-display-row">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                <span class="token-display-val" id="token-val">{{ substr($token->token ?? '', 0, 8) }}••••••••••••••••••••••••</span>
                <button class="icon-btn" onclick="toggleToken()" title="Show/Hide">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </button>
                <button class="icon-btn" onclick="copyToken()" title="Copy">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </button>
            </div>

            <p style="font-size:12px;color:var(--text-3);margin-bottom:16px;">
                Regenerating will invalidate your current token. You'll need to update it in the desktop app.
            </p>

            <button type="button" class="btn btn-ghost btn-sm" onclick="openRegenModal()">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Regenerate Token
            </button>
        </div>
    </div>

    {{-- Plan --}}
    <div class="settings-card">
        <div class="settings-card-head">
            <h2>Current Plan</h2>
            <p>Your subscription and plan details</p>
        </div>
        <div class="settings-card-body">
            <div class="plan-info">
                <div class="plan-info-left">
                    <h3>{{ ucfirst($user->plan ?? 'free') }} Plan</h3>
                    <p>{{ ($user->plan ?? 'free') === 'free' ? 'Free forever' : 'Billed monthly' }}</p>
                </div>
                @if(($user->plan ?? 'free') === 'free')
                <button onclick="openComingSoon()" class="btn btn-primary btn-sm">Upgrade to Pro</button>
                @else
                <span class="badge badge-green">Active</span>
                @endif
            </div>

            @php
                $planSetting = \App\Models\PlanSetting::where('plan', $user->plan ?? 'free')->first();
            @endphp
            @if($planSetting)
            <div class="plan-features">
                <div class="plan-feature">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ $planSetting->max_tunnels }} tunnel{{ $planSetting->max_tunnels > 1 ? 's' : '' }}
                </div>
                <div class="plan-feature">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    {{ $planSetting->max_requests_per_day === -1 ? 'Unlimited' : number_format($planSetting->max_requests_per_day) }} requests/day
                </div>
                <div class="plan-feature {{ $planSetting->has_custom_subdomain ? '' : 'disabled' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($planSetting->has_custom_subdomain)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        @endif
                    </svg>
                    Custom subdomain
                </div>
                <div class="plan-feature {{ $planSetting->has_password_protection ? '' : 'disabled' }}">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        @if($planSetting->has_password_protection)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        @endif
                    </svg>
                    Password protection
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Danger Zone --}}
    <div class="settings-card danger-zone">
        <div class="settings-card-head">
            <h2>Danger Zone</h2>
            <p>Permanently delete your account and all data</p>
        </div>
        <div class="settings-card-body">
            @if($errors->has('confirm_delete'))
            <div class="alert alert-error">{{ $errors->first('confirm_delete') }}</div>
            @endif

            <p style="font-size:13px;color:var(--text-2);margin-bottom:16px;line-height:1.6;">
                Once you delete your account, all your tunnels, tokens, and data will be permanently removed. This action cannot be undone.
            </p>

            <div class="danger-input-row">
                <input class="input" type="text" id="delete-confirm-input" placeholder="Type DELETE to confirm" style="border-color: rgba(255,95,126,0.3);" oninput="checkDeleteInput(this.value)">
                <button type="button" id="delete-account-btn" class="btn btn-danger btn-sm" style="white-space:nowrap;opacity:0.4;cursor:not-allowed;" disabled onclick="openDeleteModal()">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete Account
                </button>
            </div>
        </div>
    </div>

</div>
{{-- REGENERATE TOKEN MODAL --}}
<div class="modal-overlay" id="regen-modal">
    <div class="modal-box">
        <div class="modal-head">
            <h3>Regenerate Token</h3>
            <button onclick="closeRegenModal()">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <p style="font-size:14px;color:var(--text-2);line-height:1.6;">Are you sure you want to regenerate your auth token?</p>
            <div class="modal-warn">
                <p>⚠️ Your current Electron app connection will stop working. You'll need to paste the new token in the desktop app.</p>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="closeRegenModal()">Cancel</button>
            <form method="POST" action="{{ route('settings.token') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Yes, Regenerate
                </button>
            </form>
        </div>
    </div>
</div>

{{-- DELETE ACCOUNT MODAL --}}
<div class="modal-overlay" id="delete-modal">
    <div class="modal-box">
        <div class="modal-head">
            <h3 style="color:var(--red);">Delete Account</h3>
            <button onclick="closeDeleteModal()">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <p style="font-size:14px;color:var(--text-2);line-height:1.6;">This will <strong style="color:var(--text)">permanently delete</strong> your account, all tunnels, and tokens. This action <strong style="color:var(--red)">cannot be undone.</strong></p>
            <div class="modal-danger-info">
                <p>All your data will be permanently removed from our servers.</p>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="closeDeleteModal()">Cancel</button>
            <form method="POST" action="{{ route('settings.delete') }}">
                @csrf
                @method('DELETE')
                <input type="hidden" name="confirm_delete" value="DELETE">
                <button type="submit" class="btn btn-danger">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Yes, Delete Forever
                </button>
            </form>
        </div>
    </div>
</div>

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
    const FULL_TOKEN = '{{ $token->token ?? '' }}';
    let tokenVisible = false;

    function toggleToken() {
        tokenVisible = !tokenVisible;
        document.getElementById('token-val').textContent = tokenVisible
            ? FULL_TOKEN
            : FULL_TOKEN.substring(0, 8) + '••••••••••••••••••••••••';
    }

    function copyToken() {
        navigator.clipboard.writeText(FULL_TOKEN);
        showToast('Token copied!');
    }

    function openRegenModal() {
        document.getElementById('regen-modal').classList.add('open');
    }
    function closeRegenModal() {
        document.getElementById('regen-modal').classList.remove('open');
    }

    function checkDeleteInput(val) {
        const btn = document.getElementById('delete-account-btn');
        if (val === 'DELETE') {
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
        } else {
            btn.disabled = true;
            btn.style.opacity = '0.4';
            btn.style.cursor = 'not-allowed';
        }
    }

    function openDeleteModal() {
        document.getElementById('delete-modal').classList.add('open');
    }
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.remove('open');
    }
    function openComingSoon() {
        document.getElementById('coming-soon-modal').style.display = 'flex';
    }
    function closeComingSoon() {
        document.getElementById('coming-soon-modal').style.display = 'none';
    }
</script>
@endsection

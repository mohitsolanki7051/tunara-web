@extends('admin.layout')
@section('title', 'Plan Settings — Admin')
@section('page-title', 'Plan Settings')
@section('page-subtitle', 'Configure free and pro plan limits')

@section('head')
<style>
    .plans-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .plan-card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .plan-card-head { padding: 18px 22px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 10px; }
    .plan-card-head h2 { font-size: 15px; font-weight: 700; }
    .plan-card-body { padding: 22px; }
    .plan-badge-free { background: rgba(255,255,255,0.05); color: var(--text-3); padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
    .plan-badge-pro { background: rgba(91,127,255,0.1); color: var(--accent); padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }

    .field-group { margin-bottom: 18px; }
    .field-group label { display: block; font-size: 13px; font-weight: 500; color: var(--text-2); margin-bottom: 6px; }
    .field-hint { font-size: 11px; color: var(--text-3); margin-top: 5px; }

    .toggle-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border); }
    .toggle-row:last-of-type { border-bottom: none; }
    .toggle-label { font-size: 13.5px; font-weight: 500; }
    .toggle-desc { font-size: 12px; color: var(--text-3); margin-top: 2px; }
    .toggle { position: relative; width: 40px; height: 22px; flex-shrink: 0; }
    .toggle input { opacity: 0; width: 0; height: 0; }
    .toggle-slider { position: absolute; inset: 0; background: var(--bg-4); border-radius: 22px; cursor: pointer; transition: 0.2s; border: 1px solid var(--border); }
    .toggle-slider:before { content: ''; position: absolute; width: 16px; height: 16px; left: 2px; top: 2px; background: var(--text-3); border-radius: 50%; transition: 0.2s; }
    .toggle input:checked + .toggle-slider { background: var(--accent); border-color: var(--accent); }
    .toggle input:checked + .toggle-slider:before { transform: translateX(18px); background: white; }

    .save-row { margin-top: 24px; display: flex; justify-content: flex-end; }
</style>
@endsection

@section('content')

@if(session('success'))
<div class="alert-success">✓ {{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}">
@csrf

<div class="plans-grid">

    {{-- Free Plan --}}
    <div class="plan-card">
        <div class="plan-card-head">
            <h2>Free Plan</h2>
            <span class="plan-badge-free">FREE</span>
        </div>
        <div class="plan-card-body">

            <div class="field-group">
                <label>Price ($/month)</label>
                <input class="input" type="number" name="free_price" value="{{ $free->price ?? 0 }}" min="0" step="0.01">
                <p class="field-hint">Set to 0 for free</p>
            </div>

            <div class="field-group">
                <label>Max Tunnels</label>
                <input class="input" type="number" name="free_max_tunnels" value="{{ $free->max_tunnels ?? 1 }}" min="1">
                <p class="field-hint">Number of tunnels a free user can create</p>
            </div>

            <div class="field-group">
                <label>Max Requests/Day</label>
                <input class="input" type="number" name="free_max_requests" value="{{ $free->max_requests_per_day ?? 1000 }}" min="-1">
                <p class="field-hint">Set -1 for unlimited</p>
            </div>

            <div class="toggle-row">
                <div>
                    <div class="toggle-label">Custom Subdomain</div>
                    <div class="toggle-desc">Allow custom subdomain URLs</div>
                </div>
                <label class="toggle">
                    <input type="checkbox" name="free_custom_subdomain" {{ ($free->has_custom_subdomain ?? false) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>

            <div class="toggle-row">
                <div>
                    <div class="toggle-label">Password Protection</div>
                    <div class="toggle-desc">Allow password-protected tunnels</div>
                </div>
                <label class="toggle">
                    <input type="checkbox" name="free_password_protection" {{ ($free->has_password_protection ?? false) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>

        </div>
    </div>

    {{-- Pro Plan --}}
    <div class="plan-card">
        <div class="plan-card-head">
            <h2>Pro Plan</h2>
            <span class="plan-badge-pro">PRO</span>
        </div>
        <div class="plan-card-body">

            <div class="field-group">
                <label>Price ($/month)</label>
                <input class="input" type="number" name="pro_price" value="{{ $pro->price ?? 9 }}" min="0" step="0.01">
            </div>

            <div class="field-group">
                <label>Max Tunnels</label>
                <input class="input" type="number" name="pro_max_tunnels" value="{{ $pro->max_tunnels ?? 5 }}" min="1">
                <p class="field-hint">Number of tunnels a pro user can create</p>
            </div>

            <div class="field-group">
                <label>Max Requests/Day</label>
                <input class="input" type="number" name="pro_max_requests" value="{{ $pro->max_requests_per_day ?? -1 }}" min="-1">
                <p class="field-hint">Set -1 for unlimited</p>
            </div>

            <div class="toggle-row">
                <div>
                    <div class="toggle-label">Custom Subdomain</div>
                    <div class="toggle-desc">Allow custom subdomain URLs</div>
                </div>
                <label class="toggle">
                    <input type="checkbox" name="pro_custom_subdomain" {{ ($pro->has_custom_subdomain ?? true) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>

            <div class="toggle-row">
                <div>
                    <div class="toggle-label">Password Protection</div>
                    <div class="toggle-desc">Allow password-protected tunnels</div>
                </div>
                <label class="toggle">
                    <input type="checkbox" name="pro_password_protection" {{ ($pro->has_password_protection ?? true) ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>

        </div>
    </div>
</div>

<div class="save-row">
    <button type="submit" class="btn btn-primary">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        Save Settings
    </button>
</div>

</form>
@endsection

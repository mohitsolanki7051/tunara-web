@extends('admin.layout')
@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of your Tunara instance')

@section('head')
<style>
    .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
    .stat { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px 22px; }
    .stat-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .stat-label { font-size: 13px; color: var(--text-2); }
    .stat-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
    .stat-icon svg { width: 15px; height: 15px; }
    .stat-icon-blue { background: rgba(91,127,255,0.12); color: var(--accent); }
    .stat-icon-green { background: rgba(32,212,160,0.1); color: var(--green); }
    .stat-icon-purple { background: rgba(167,139,250,0.1); color: var(--accent-2); }
    .stat-icon-red { background: rgba(255,95,126,0.1); color: var(--red); }
    .stat-value { font-size: 30px; font-weight: 700; letter-spacing: -0.02em; }
    .stat-sub { font-size: 12px; color: var(--text-3); margin-top: 3px; }

    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

    .section-card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .section-head { padding: 16px 20px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
    .section-head h2 { font-size: 14px; font-weight: 600; }
    .section-head a { font-size: 12px; color: var(--accent); }

    .user-row { display: flex; align-items: center; gap: 12px; padding: 12px 20px; border-bottom: 1px solid var(--border); }
    .user-row:last-child { border-bottom: none; }
    .user-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), var(--accent-2)); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; flex-shrink: 0; }
    .user-name { font-size: 13.5px; font-weight: 500; }
    .user-email { font-size: 12px; color: var(--text-3); }
    .user-date { font-size: 11px; color: var(--text-3); margin-left: auto; }

    .plan-row { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--border); }
    .plan-row:last-child { border-bottom: none; }
    .plan-name { font-size: 14px; font-weight: 600; }
    .plan-detail { font-size: 12px; color: var(--text-2); margin-top: 2px; }
    .plan-price { font-size: 18px; font-weight: 700; }
    .plan-price span { font-size: 12px; color: var(--text-3); font-weight: 400; }
</style>
@endsection

@section('content')

<div class="stats">
    <div class="stat">
        <div class="stat-top">
            <span class="stat-label">Total Users</span>
            <div class="stat-icon stat-icon-blue">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>
        <div class="stat-value">{{ $totalUsers }}</div>
        <div class="stat-sub">registered accounts</div>
    </div>
    <div class="stat">
        <div class="stat-top">
            <span class="stat-label">Free Users</span>
            <div class="stat-icon stat-icon-green">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="stat-value">{{ $freeUsers }}</div>
        <div class="stat-sub">on free plan</div>
    </div>
    <div class="stat">
        <div class="stat-top">
            <span class="stat-label">Pro Users</span>
            <div class="stat-icon stat-icon-purple">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
        </div>
        <div class="stat-value">{{ $proUsers }}</div>
        <div class="stat-sub">on pro plan</div>
    </div>
    <div class="stat">
        <div class="stat-top">
            <span class="stat-label">Total Tunnels</span>
            <div class="stat-icon stat-icon-red">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </div>
        <div class="stat-value">{{ $totalTunnels }}</div>
        <div class="stat-sub">tunnels created</div>
    </div>
</div>

<div class="grid-2">
    {{-- Recent Users --}}
    <div class="section-card">
        <div class="section-head">
            <h2>Recent Users</h2>
            <a href="{{ route('admin.users') }}">View all →</a>
        </div>
        @forelse($recentUsers as $user)
        <div class="user-row">
            <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ $user->name }}</div>
                <div class="user-email">{{ $user->email }}</div>
            </div>
            <div style="margin-left:auto;display:flex;align-items:center;gap:8px;">
                <span class="badge {{ ($user->plan ?? 'free') === 'pro' ? 'badge-blue' : 'badge-gray' }}">
                    {{ ucfirst($user->plan ?? 'free') }}
                </span>
                <span class="user-date">{{ $user->created_at->diffForHumans() }}</span>
            </div>
        </div>
        @empty
        <div style="padding:40px;text-align:center;color:var(--text-3);font-size:13px;">No users yet</div>
        @endforelse
    </div>

    {{-- Plan Overview --}}
    <div class="section-card">
        <div class="section-head">
            <h2>Plan Overview</h2>
            <a href="{{ route('admin.settings') }}">Edit →</a>
        </div>

        @foreach(['free', 'pro'] as $planName)
        @if(isset($plans[$planName]))
        @php $plan = $plans[$planName]; @endphp
        <div class="plan-row">
            <div>
                <div class="plan-name">{{ ucfirst($plan->plan) }} Plan</div>
                <div class="plan-detail">
                    {{ $plan->max_tunnels }} tunnel{{ $plan->max_tunnels > 1 ? 's' : '' }} •
                    {{ $plan->max_requests_per_day === -1 ? 'Unlimited' : number_format($plan->max_requests_per_day) }} requests/day
                </div>
            </div>
            <div class="plan-price">
                ${{ number_format($plan->price, 2) }}
                <span>/mo</span>
            </div>
        </div>
        @endif
        @endforeach

        @if($plans->isEmpty())
        <div style="padding:40px;text-align:center;color:var(--text-3);font-size:13px;">
            <p>No plan settings yet.</p>
            <a href="{{ route('admin.settings') }}" style="color:var(--accent);font-size:13px;">Set up plans →</a>
        </div>
        @endif
    </div>
</div>

@endsection

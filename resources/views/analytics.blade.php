@extends('layouts.dashboard')
@section('title', 'Analytics')
@section('page-title', 'Analytics')
@section('page-subtitle', 'Track your tunnel traffic and usage')

@section('head')
<style>
    .an-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
    .an-stat { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px 22px; }
    .an-stat-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
    .an-stat-label { font-size: 12px; color: var(--text-2); }
    .an-stat-value { font-size: 30px; font-weight: 700; letter-spacing: -0.02em; }
    .an-stat-sub { font-size: 11px; color: var(--text-3); margin-top: 4px; }

    .an-card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); padding: 22px; margin-bottom: 20px; }
    .an-card-title { font-size: 13px; font-weight: 600; color: var(--text-2); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 18px; }

    /* Progress */
    .an-progress-track { height: 8px; background: var(--bg-4); border-radius: 99px; overflow: hidden; margin-top: 10px; }
    .an-progress-bar { height: 100%; border-radius: 99px; background: linear-gradient(90deg, var(--accent), var(--accent-2)); transition: width 0.6s ease; }
    .an-progress-bar.danger { background: linear-gradient(90deg, #f97316, var(--red)); }

    /* Chart */
    .an-chart { display: flex; align-items: flex-end; gap: 10px; height: 120px; }
    .an-bar-wrap { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 5px; height: 100%; justify-content: flex-end; }
    .an-bar { width: 100%; border-radius: 5px 5px 0 0; background: linear-gradient(180deg, var(--accent), rgba(91,127,255,0.35)); min-height: 4px; }
    .an-bar.today { background: linear-gradient(180deg, var(--accent-2), rgba(167,139,250,0.4)); }
    .an-bar-count { font-size: 11px; color: var(--text-3); }
    .an-bar-day { font-size: 11px; color: var(--text-3); }
    .an-bar-day.is-today { color: var(--accent-2); font-weight: 600; }

    /* Per tunnel table */
    .an-table { width: 100%; border-collapse: collapse; }
    .an-table th { font-size: 11px; font-weight: 600; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.06em; padding: 0 0 12px; text-align: left; border-bottom: 1px solid var(--border); }
    .an-table td { padding: 12px 0; border-bottom: 1px solid var(--border); font-size: 13px; vertical-align: middle; }
    .an-table tr:last-child td { border-bottom: none; }
    .an-table .mono { font-family: var(--mono); font-size: 12px; color: var(--accent); }
    .an-table .count { font-weight: 700; color: var(--text); }
    .an-table .sub { font-size: 11px; color: var(--text-3); margin-top: 2px; }

    .usage-label { display: flex; justify-content: space-between; font-size: 12px; color: var(--text-3); margin-bottom: 6px; }
</style>
@endsection

@section('content')

@php
    $remaining = $maxRequests === -1 ? null : max(0, $maxRequests - $todayTotal);
    $pct       = ($maxRequests > 0 && $maxRequests !== -1) ? min(100, round(($todayTotal / $maxRequests) * 100)) : 0;
    $todayStr  = now()->toDateString();
@endphp

{{-- Top Stats --}}
<div class="an-grid">
    <div class="an-stat">
        <div class="an-stat-top">
            <span class="an-stat-label">Today's Requests</span>
            <div class="stat-icon stat-icon-blue">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
        </div>
        <div class="an-stat-value">{{ $todayTotal }}</div>
        <div class="an-stat-sub">served today</div>
    </div>
    <div class="an-stat">
        <div class="an-stat-top">
            <span class="an-stat-label">Remaining Today</span>
            <div class="stat-icon stat-icon-green">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </div>
        <div class="an-stat-value">{{ $remaining === null ? '∞' : $remaining }}</div>
        <div class="an-stat-sub">resets at midnight</div>
    </div>
    <div class="an-stat">
        <div class="an-stat-top">
            <span class="an-stat-label">Daily Limit</span>
            <div class="stat-icon stat-icon-purple">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="an-stat-value">{{ $maxRequests === -1 ? '∞' : $maxRequests }}</div>
        <div class="an-stat-sub">{{ $userPlan === 'pro' ? 'Pro — unlimited' : 'Free plan limit' }}</div>
    </div>
    <div class="an-stat">
        <div class="an-stat-top">
            <span class="an-stat-label">Last 30 Days</span>
            <div class="stat-icon stat-icon-blue">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <div class="an-stat-value">{{ $last30 }}</div>
        <div class="an-stat-sub">total requests</div>
    </div>
</div>

{{-- Usage Progress --}}
@if($maxRequests !== -1)
<div class="an-card">
    <div class="an-card-title">Daily Usage</div>
    <div class="usage-label">
        <span>{{ $todayTotal }} of {{ $maxRequests }} requests used</span>
        <span>{{ $pct }}%</span>
    </div>
    <div class="an-progress-track">
        <div class="an-progress-bar {{ $pct >= 85 ? 'danger' : '' }}" style="width: {{ $pct }}%"></div>
    </div>
    @if($pct >= 85)
    <p style="font-size:12px;color:var(--red);margin-top:10px;">⚠️ Approaching daily limit. <a href="#" style="color:var(--accent);">Upgrade to Pro</a> for unlimited requests.</p>
    @endif
</div>
@endif

{{-- Weekly Chart --}}
<div class="an-card">
    <div class="an-card-title">Last 7 Days</div>
    @php $maxVal = max(array_values($weekly) ?: [1]); @endphp
    <div class="an-chart">
        @foreach($weekly as $date => $count)
        @php
            $h      = $maxVal > 0 ? max(4, round(($count / $maxVal) * 110)) : 4;
            $isToday = $date === $todayStr;
            $day    = \Carbon\Carbon::parse($date)->format('D');
        @endphp
        <div class="an-bar-wrap">
            <span class="an-bar-count">{{ $count }}</span>
            <div class="an-bar {{ $isToday ? 'today' : '' }}" style="height: {{ $h }}px"></div>
            <span class="an-bar-day {{ $isToday ? 'is-today' : '' }}">{{ $isToday ? 'Today' : $day }}</span>
        </div>
        @endforeach
    </div>
</div>

{{-- Per Tunnel Table --}}
<div class="an-card">
    <div class="an-card-title">Per Tunnel — Today</div>
    @if($perTunnel->isEmpty())
        <p style="font-size:13px;color:var(--text-3);">No tunnel activity today.</p>
    @else
    <table class="an-table">
        <thead>
            <tr>
                <th>Local URL</th>
                <th>Public URL</th>
                <th style="text-align:right;">Requests Today</th>
            </tr>
        </thead>
        <tbody>
            @foreach($perTunnel as $t)
            <tr>
                <td><span class="mono">{{ $t['local_url'] }}</span></td>
                <td><span class="mono">{{ $t['public_url'] }}</span></td>
                <td style="text-align:right;"><span class="count">{{ $t['today'] }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

@endsection

@extends('layouts.dashboard')
@section('title', 'Analytics')
@section('page-title', 'Analytics')
@section('page-subtitle', 'Track your tunnel traffic and usage')

@section('head')
<style>
    /* ── Period Tabs ── */
    .period-tabs { display: flex; gap: 6px; background: var(--bg-2); border: 1px solid var(--border); border-radius: 10px; padding: 4px; width: fit-content; margin-bottom: 24px; }
    .period-tab { padding: 7px 16px; border-radius: 7px; font-size: 13px; font-weight: 500; color: var(--text-3); cursor: pointer; border: none; background: none; font-family: var(--font); transition: all 0.15s; text-decoration: none; }
    .period-tab:hover { color: var(--text-2); }
    .period-tab.active { background: linear-gradient(135deg, var(--accent), var(--accent-2)); color: white; }

    /* ── Stat Grid ── */
    .an-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
    .an-stat { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px 22px; position: relative; overflow: hidden; transition: border-color 0.2s; }
    .an-stat:hover { border-color: var(--border-2); }
    .an-stat::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; border-radius: var(--radius) var(--radius) 0 0; }
    .an-stat.blue::before { background: linear-gradient(90deg, var(--accent), transparent); }
    .an-stat.green::before { background: linear-gradient(90deg, var(--green), transparent); }
    .an-stat.purple::before { background: linear-gradient(90deg, var(--accent-2), transparent); }
    .an-stat.orange::before { background: linear-gradient(90deg, #f97316, transparent); }
    .an-stat-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
    .an-stat-label { font-size: 12px; font-weight: 500; color: var(--text-2); }
    .an-stat-icon { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; }
    .an-stat-icon svg { width: 16px; height: 16px; }
    .an-stat-icon.blue { background: rgba(91,127,255,0.12); color: var(--accent); }
    .an-stat-icon.green { background: rgba(32,212,160,0.1); color: var(--green); }
    .an-stat-icon.purple { background: rgba(167,139,250,0.1); color: var(--accent-2); }
    .an-stat-icon.orange { background: rgba(249,115,22,0.1); color: #f97316; }
    .an-stat-value { font-size: 32px; font-weight: 700; letter-spacing: -0.03em; line-height: 1; margin-bottom: 6px; }
    .an-stat-sub { font-size: 11px; color: var(--text-3); }

    /* ── Cards ── */
    .an-card { background: var(--bg-2); border: 1px solid var(--border); border-radius: var(--radius); padding: 24px; margin-bottom: 20px; }
    .an-card-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
    .an-card-title { font-size: 13px; font-weight: 600; color: var(--text); }
    .an-card-sub { font-size: 12px; color: var(--text-3); margin-top: 2px; }

    /* ── Progress ── */
    .an-progress-wrap { margin-bottom: 8px; }
    .an-progress-labels { display: flex; justify-content: space-between; font-size: 12px; color: var(--text-3); margin-bottom: 8px; }
    .an-progress-track { height: 8px; background: var(--bg-4); border-radius: 99px; overflow: hidden; }
    .an-progress-bar { height: 100%; border-radius: 99px; background: linear-gradient(90deg, var(--accent), var(--accent-2)); transition: width 0.8s cubic-bezier(0.4,0,0.2,1); }
    .an-progress-bar.warn { background: linear-gradient(90deg, #f97316, #ef4444); }

    /* ── Chart ── */
    .an-chart-wrap { position: relative; }
    .an-chart { display: flex; align-items: flex-end; gap: 4px; height: 140px; padding-bottom: 28px; }
    .an-bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: flex-end; gap: 0; height: 100%; position: relative; cursor: pointer; }
    .an-bar-col:hover .an-bar { opacity: 0.85; }
    .an-bar-col:hover .an-tooltip { opacity: 1; pointer-events: auto; transform: translateY(0); }
    .an-bar { width: 100%; border-radius: 4px 4px 0 0; background: rgba(91,127,255,0.25); min-height: 3px; transition: all 0.4s ease; position: relative; }
    .an-bar.has-data { background: linear-gradient(180deg, var(--accent) 0%, rgba(91,127,255,0.5) 100%); }
    .an-bar.today { background: linear-gradient(180deg, var(--accent-2) 0%, rgba(167,139,250,0.5) 100%) !important; }
    .an-bar-label { position: absolute; bottom: 0; font-size: 9px; color: var(--text-3); white-space: nowrap; transform: translateX(-50%); left: 50%; padding-top: 4px; margin-top: 4px; }
    .an-bar-label.today-label { color: var(--accent-2); font-weight: 600; }

    .an-tooltip { position: absolute; bottom: calc(100% + 6px); left: 50%; transform: translateX(-50%) translateY(4px); background: var(--bg-4); border: 1px solid var(--border-2); border-radius: 6px; padding: 5px 10px; font-size: 11px; font-weight: 600; white-space: nowrap; opacity: 0; pointer-events: none; transition: all 0.15s; z-index: 10; color: var(--text); }
    .an-tooltip::after { content: ''; position: absolute; top: 100%; left: 50%; transform: translateX(-50%); border: 4px solid transparent; border-top-color: var(--border-2); }

    .chart-zero { display: flex; flex-direction: column; align-items: center; justify-content: center; height: 140px; color: var(--text-3); font-size: 13px; gap: 8px; }
    .chart-zero svg { width: 32px; height: 32px; opacity: 0.3; }

    /* ── Table ── */
    .an-table-wrap { overflow-x: auto; }
    .an-table { width: 100%; border-collapse: collapse; }
    .an-table th { font-size: 11px; font-weight: 600; color: var(--text-3); text-transform: uppercase; letter-spacing: 0.07em; padding: 0 16px 12px 0; text-align: left; border-bottom: 1px solid var(--border); white-space: nowrap; }
    .an-table th:last-child { text-align: right; padding-right: 0; }
    .an-table td { padding: 14px 16px 14px 0; border-bottom: 1px solid var(--border); vertical-align: middle; }
    .an-table td:last-child { padding-right: 0; }
    .an-table tr:last-child td { border-bottom: none; }
    .an-table tr:hover td { background: rgba(255,255,255,0.01); }
    .an-mono { font-family: var(--mono); font-size: 12px; color: var(--accent); }
    .an-mono.gray { color: var(--text-3); }
    .an-count-badge { display: inline-flex; align-items: center; justify-content: center; background: rgba(91,127,255,0.1); color: var(--accent); border: 1px solid rgba(91,127,255,0.2); border-radius: 6px; padding: 3px 10px; font-size: 12px; font-weight: 700; min-width: 48px; }
    .an-count-badge.zero { background: var(--bg-3); color: var(--text-3); border-color: var(--border); }

    /* ── Upgrade Banner ── */
    .upgrade-banner { background: linear-gradient(135deg, rgba(91,127,255,0.08), rgba(167,139,250,0.08)); border: 1px solid rgba(91,127,255,0.2); border-radius: var(--radius); padding: 16px 20px; display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
    .upgrade-banner-icon { width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, var(--accent), var(--accent-2)); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .upgrade-banner-icon svg { width: 18px; height: 18px; color: white; }
    .upgrade-banner p:first-child { font-size: 13px; font-weight: 600; color: var(--text); }
    .upgrade-banner p:last-child { font-size: 12px; color: var(--text-2); margin-top: 2px; }
    .upgrade-banner a { margin-left: auto; flex-shrink: 0; }

    .empty-state-sm { text-align: center; padding: 32px 20px; color: var(--text-3); font-size: 13px; }
</style>
@endsection

@section('content')

@php
    $remaining = $maxRequests === -1 ? null : max(0, $maxRequests - $todayTotal);
    $pct       = ($maxRequests > 0 && $maxRequests !== -1) ? min(100, round(($todayTotal / $maxRequests) * 100)) : 0;
    $todayStr  = now()->toDateString();
    $totalChart = array_sum($chartData);
    $periodLabel = match($period) {
        '30days'  => 'Last 30 Days',
        '6months' => 'Last 6 Months',
        '1year'   => 'Last Year',
        default   => 'Last 7 Days',
    };
@endphp

{{-- Period Tabs --}}
<div class="period-tabs">
    @foreach(['7days' => '7 Days', '30days' => '30 Days', '6months' => '6 Months', '1year' => '1 Year'] as $val => $label)
    <a href="{{ route('analytics', ['period' => $val]) }}"
       class="period-tab {{ $period === $val ? 'active' : '' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

{{-- Upgrade warning --}}
@if($pct >= 85 && $maxRequests !== -1)
<div class="upgrade-banner">
    <div class="upgrade-banner-icon">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
    </div>
    <div>
        <p>Approaching Daily Limit</p>
        <p>{{ $todayTotal }} of {{ $maxRequests }} requests used today. Upgrade to Pro for unlimited.</p>
    </div>
    <a href="#" class="btn btn-primary btn-sm">Upgrade to Pro</a>
</div>
@endif

{{-- Stats Grid --}}
<div class="an-grid">
    <div class="an-stat blue">
        <div class="an-stat-top">
            <span class="an-stat-label">Today's Requests</span>
            <div class="an-stat-icon blue">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
        </div>
        <div class="an-stat-value">{{ $todayTotal }}</div>
        <div class="an-stat-sub">served today</div>
    </div>
    <div class="an-stat green">
        <div class="an-stat-top">
            <span class="an-stat-label">Remaining Today</span>
            <div class="an-stat-icon green">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
        </div>
        <div class="an-stat-value">{{ $remaining === null ? '∞' : $remaining }}</div>
        <div class="an-stat-sub">resets at midnight</div>
    </div>
    <div class="an-stat purple">
        <div class="an-stat-top">
            <span class="an-stat-label">{{ $periodLabel }}</span>
            <div class="an-stat-icon purple">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <div class="an-stat-value">{{ $periodTotal }}</div>
        <div class="an-stat-sub">total in period</div>
    </div>
    <div class="an-stat {{ $pct >= 85 ? 'orange' : 'blue' }}">
        <div class="an-stat-top">
            <span class="an-stat-label">Daily Limit</span>
            <div class="an-stat-icon {{ $pct >= 85 ? 'orange' : 'blue' }}">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="an-stat-value">{{ $maxRequests === -1 ? '∞' : $maxRequests }}</div>
        <div class="an-stat-sub">{{ $userPlan === 'pro' ? 'Pro — unlimited' : 'Free plan' }}</div>
    </div>
</div>

{{-- Progress Bar --}}
@if($maxRequests !== -1)
<div class="an-card" style="padding: 20px 24px; margin-bottom: 20px;">
    <div class="an-card-head" style="margin-bottom: 12px;">
        <div>
            <div class="an-card-title">Daily Usage</div>
            <div class="an-card-sub">Resets at midnight</div>
        </div>
        <span style="font-size: 22px; font-weight: 700; color: {{ $pct >= 85 ? '#f97316' : 'var(--accent)' }}">{{ $pct }}%</span>
    </div>
    <div class="an-progress-labels">
        <span>{{ $todayTotal }} requests used</span>
        <span>{{ $maxRequests }} limit</span>
    </div>
    <div class="an-progress-track">
        <div class="an-progress-bar {{ $pct >= 85 ? 'warn' : '' }}" style="width: {{ $pct }}%"></div>
    </div>
</div>
@endif

{{-- Chart --}}
<div class="an-card">
    <div class="an-card-head">
        <div>
            <div class="an-card-title">Request Volume</div>
            <div class="an-card-sub">{{ $periodLabel }}</div>
        </div>
        <span style="font-size: 13px; font-weight: 600; color: var(--accent);">{{ $periodTotal }} total</span>
    </div>

    @if($totalChart === 0)
    <div class="chart-zero">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        No traffic data for this period
    </div>
    @else
    @php $maxVal = max(array_values($chartData) ?: [1]); @endphp
    <div class="an-chart">
        @foreach($chartData as $date => $count)
        @php
            $h       = $maxVal > 0 ? max(3, round(($count / $maxVal) * 112)) : 3;
            $isToday = $date === $todayStr;
            $label   = in_array($period, ['6months', '1year'])
                ? \Carbon\Carbon::parse($date)->format('M d')
                : ($isToday ? 'Today' : \Carbon\Carbon::parse($date)->format('D'));
        @endphp
        <div class="an-bar-col">
            <div class="an-tooltip">{{ $count }} req</div>
            <div class="an-bar {{ $count > 0 ? 'has-data' : '' }} {{ $isToday ? 'today' : '' }}"
                 style="height: {{ $h }}px"></div>
            <span class="an-bar-label {{ $isToday ? 'today-label' : '' }}">{{ $label }}</span>
        </div>
        @endforeach
    </div>
    @endif
</div>

{{-- Per Tunnel Table --}}
<div class="an-card" style="margin-bottom: 0;">
    <div class="an-card-head">
        <div>
            <div class="an-card-title">Per Tunnel</div>
            <div class="an-card-sub">Today's breakdown</div>
        </div>
    </div>

    @if($perTunnel->isEmpty())
        <div class="empty-state-sm">No tunnels found.</div>
    @else
    <div class="an-table-wrap">
        <table class="an-table">
            <thead>
                <tr>
                    <th>Local URL</th>
                    <th>Public URL</th>
                    <th style="text-align:right;">Today</th>
                </tr>
            </thead>
            <tbody>
                @foreach($perTunnel as $t)
                <tr>
                    <td><span class="an-mono gray">{{ $t['local_url'] }}</span></td>
                    <td>
                        <a href="{{ $t['public_url'] }}" target="_blank" class="an-mono">
                            {{ $t['public_url'] }}
                        </a>
                    </td>
                    <td style="text-align:right;">
                        <span class="an-count-badge {{ $t['today'] === 0 ? 'zero' : '' }}">
                            {{ $t['today'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

@endsection

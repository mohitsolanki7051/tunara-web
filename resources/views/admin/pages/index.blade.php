@extends('admin.layout')
@section('title', 'Pages')

@section('content')
<div class="page-header">
    <h1 class="page-title">Pages</h1>
    <p class="page-sub">Manage content for public-facing pages</p>
</div>

@if(session('success'))
<div style="background:rgba(32,212,160,0.08);border:1px solid rgba(32,212,160,0.2);border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#20d4a0;display:flex;align-items:center;gap:8px;">
    <span>✓</span> {{ session('success') }}
</div>
@endif

<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;">
    @php
        $icons = ['about' => '👤', 'contact' => '✉️', 'privacy' => '🔒', 'terms' => '📄'];
        $descs = [
            'about'   => 'Company story, team, and mission',
            'contact' => 'Contact info shown above the form',
            'privacy' => 'Privacy policy and data handling',
            'terms'   => 'Terms of service and usage rules',
        ];
    @endphp
    @foreach($pages as $slug => $page)
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:14px;padding:22px;display:flex;flex-direction:column;gap:0;">
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:14px;">
            <div style="width:44px;height:44px;border-radius:10px;background:var(--bg-hover);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;">
                {{ $icons[$slug] ?? '📄' }}
            </div>
            <div>
                <p style="font-size:14px;font-weight:600;margin-bottom:2px;">{{ $page['title'] }}</p>
                <p style="font-size:12px;color:var(--text-muted);">{{ $descs[$slug] ?? '' }}</p>
            </div>
            <div style="margin-left:auto;">
                @if($page['exists'])
                    <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(32,212,160,0.08);color:#20d4a0;border:1px solid rgba(32,212,160,0.2);border-radius:20px;padding:3px 10px;font-size:11px;font-weight:500;">
                        <span style="width:5px;height:5px;border-radius:50%;background:#20d4a0;"></span> Published
                    </span>
                @else
                    <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,0.04);color:var(--text-muted);border:1px solid var(--border);border-radius:20px;padding:3px 10px;font-size:11px;font-weight:500;">
                        <span style="width:5px;height:5px;border-radius:50%;background:var(--text-muted);"></span> Empty
                    </span>
                @endif
            </div>
        </div>

        <div style="background:var(--bg-hover);border-radius:8px;padding:10px 14px;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
            <span style="font-size:11px;color:var(--text-muted);">URL</span>
            <code style="font-size:12px;color:var(--accent);font-family:var(--mono);">/{{ $slug }}</code>
            <a href="/{{ $slug }}" target="_blank" style="margin-left:auto;font-size:11px;color:var(--text-muted);display:flex;align-items:center;gap:3px;">
                Preview
                <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>

        <a href="{{ route('admin.pages.edit', $slug) }}" class="btn btn-primary btn-sm" style="width:100%;justify-content:center;">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit Content
        </a>
    </div>
    @endforeach
</div>
@endsection

@extends('admin.layout')
@section('title', 'Reviews')

@section('content')
<div class="admin-header">
    <h1>Reviews</h1>
</div>

@if(session('success'))
<div class="alert-success" style="background:rgba(16,217,138,0.1);border:1px solid rgba(16,217,138,0.2);border-radius:8px;padding:12px 16px;margin-bottom:20px;color:#10d98a;font-size:13px;">
    {{ session('success') }}
</div>
@endif

{{-- Pending Reviews --}}
<div class="card" style="margin-bottom:24px;">
    <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
        <h2 style="font-size:14px;font-weight:600;">Pending Reviews <span style="background:rgba(251,191,36,0.1);color:#fbbf24;border-radius:100px;padding:2px 8px;font-size:11px;margin-left:8px;">{{ $pending->count() }}</span></h2>
    </div>
    @if($pending->isEmpty())
    <div style="padding:32px;text-align:center;color:var(--text-3);font-size:13px;">No pending reviews</div>
    @else
    @foreach($pending as $review)
    <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;gap:16px;align-items:flex-start;">
        <div style="flex:1;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                <span style="font-size:13px;font-weight:600;">{{ $review->name }}</span>
                @if($review->role)<span style="font-size:11px;color:var(--text-3);">{{ $review->role }}</span>@endif
                <span style="color:#fbbf24;font-size:12px;">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
            </div>
            <p style="font-size:13px;color:var(--text-2);line-height:1.6;">"{{ $review->text }}"</p>
            <span style="font-size:11px;color:var(--text-3);font-family:monospace;">{{ $review->created_at->diffForHumans() }}</span>
        </div>
        <div style="display:flex;gap:8px;flex-shrink:0;">
            <form method="POST" action="{{ route('admin.reviews.approve', $review->id) }}">
                @csrf
                <button type="submit" style="padding:6px 14px;background:rgba(16,217,138,0.1);border:1px solid rgba(16,217,138,0.2);color:#10d98a;border-radius:6px;font-size:12px;cursor:pointer;">Approve</button>
            </form>
            <form method="POST" action="{{ route('admin.reviews.reject', $review->id) }}">
                @csrf
                <button type="submit" style="padding:6px 14px;background:rgba(255,77,106,0.1);border:1px solid rgba(255,77,106,0.2);color:#ff4d6a;border-radius:6px;font-size:12px;cursor:pointer;" onclick="return confirm('Delete this review?')">Delete</button>
            </form>
        </div>
    </div>
    @endforeach
    @endif
</div>

{{-- Approved Reviews --}}
<div class="card">
    <div style="padding:16px 20px;border-bottom:1px solid var(--border);">
        <h2 style="font-size:14px;font-weight:600;">Approved Reviews <span style="background:rgba(16,217,138,0.1);color:#10d98a;border-radius:100px;padding:2px 8px;font-size:11px;margin-left:8px;">{{ $approved->count() }}</span></h2>
        <p style="font-size:12px;color:var(--text-3);margin-top:4px;">Toggle "Show on Landing" to feature reviews on the homepage</p>
    </div>
    @if($approved->isEmpty())
    <div style="padding:32px;text-align:center;color:var(--text-3);font-size:13px;">No approved reviews yet</div>
    @else
    @foreach($approved as $review)
    <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;gap:16px;align-items:flex-start;">
        <div style="flex:1;">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:6px;">
                <span style="font-size:13px;font-weight:600;">{{ $review->name }}</span>
                @if($review->role)<span style="font-size:11px;color:var(--text-3);">{{ $review->role }}</span>@endif
                <span style="color:#fbbf24;font-size:12px;">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                @if($review->show_on_landing)
                <span style="background:rgba(91,127,255,0.1);color:#5b7fff;border-radius:100px;padding:2px 8px;font-size:10px;">On Landing</span>
                @endif
            </div>
            <p style="font-size:13px;color:var(--text-2);line-height:1.6;">"{{ $review->text }}"</p>
        </div>
        <div style="display:flex;gap:8px;flex-shrink:0;">
            <form method="POST" action="{{ route('admin.reviews.toggle', $review->id) }}">
                @csrf
                <button type="submit" style="padding:6px 14px;background:{{ $review->show_on_landing ? 'rgba(91,127,255,0.1)' : 'rgba(255,255,255,0.05)' }};border:1px solid {{ $review->show_on_landing ? 'rgba(91,127,255,0.2)' : 'rgba(255,255,255,0.1)' }};color:{{ $review->show_on_landing ? '#5b7fff' : 'var(--text-3)' }};border-radius:6px;font-size:12px;cursor:pointer;">
                    {{ $review->show_on_landing ? '✓ On Landing' : 'Show on Landing' }}
                </button>
            </form>
            <form method="POST" action="{{ route('admin.reviews.reject', $review->id) }}">
                @csrf
                <button type="submit" style="padding:6px 14px;background:rgba(255,77,106,0.1);border:1px solid rgba(255,77,106,0.2);color:#ff4d6a;border-radius:6px;font-size:12px;cursor:pointer;" onclick="return confirm('Delete?')">Delete</button>
            </form>
        </div>
    </div>
    @endforeach
    @endif
</div>
@endsection

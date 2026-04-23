@extends('layouts.public')
@section('title', 'Terms of Service — Tunara')

@section('content')
<section style="max-width:780px;margin:0 auto;padding:120px 48px 80px;">
    <div style="font-family:var(--mono);font-size:10px;font-weight:500;letter-spacing:0.15em;text-transform:uppercase;color:var(--accent);margin-bottom:14px;">Legal</div>
    <h1 style="font-size:clamp(28px,4vw,48px);font-weight:800;letter-spacing:-0.03em;margin-bottom:16px;">{{ $page->title ?? 'Terms of Service' }}</h1>
    <div style="font-size:15px;color:var(--text-2);line-height:1.85;">
        {!! $page->content ?? '<p>Content coming soon.</p>' !!}
    </div>
</section>
@endsection

@extends('layouts.public')
@section('title', 'Contact — Tunara')

@section('content')
<section style="max-width:680px;margin:0 auto;padding:120px 48px 80px;">
    <div style="font-family:var(--mono);font-size:10px;font-weight:500;letter-spacing:0.15em;text-transform:uppercase;color:var(--accent);margin-bottom:14px;">Contact</div>
    <h1 style="font-size:clamp(28px,4vw,48px);font-weight:800;letter-spacing:-0.03em;margin-bottom:10px;">{{ $page->title ?? 'Get in touch' }}</h1>

    @if($page && $page->content)
    <div style="font-size:15px;color:var(--text-2);line-height:1.85;margin-bottom:36px;">
        {!! $page->content !!}
    </div>
    @else
    <p style="font-size:15px;color:var(--text-2);margin-bottom:36px;">Have a question or feedback? We'd love to hear from you.</p>
    @endif

    @if(session('contact_success'))
    <div style="background:rgba(16,217,138,0.08);border:1px solid rgba(16,217,138,0.2);border-radius:10px;padding:16px 20px;margin-bottom:24px;font-size:14px;color:#10d98a;">
        ✓ {{ session('contact_success') }}
    </div>
    @endif

    <div style="background:var(--bg-2);border:1px solid var(--border-2);border-radius:20px;padding:36px;position:relative;overflow:hidden;">
        <div style="position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,var(--accent),transparent);"></div>

        <form method="POST" action="{{ route('contact.submit') }}">
            @csrf
            <div style="display:none;" aria-hidden="true">
                <input type="text" name="website" value="" tabindex="-1" autocomplete="off">
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
                <div>
                    <label style="font-size:12px;font-weight:500;color:var(--text-2);display:block;margin-bottom:6px;">Your Name *</label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="John Doe"
                        style="width:100%;background:var(--bg-3);border:1px solid var(--border-2);border-radius:8px;padding:10px 14px;font-size:13px;color:var(--text);outline:none;font-family:var(--font);"
                        onfocus="this.style.borderColor='var(--accent)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                    @error('name')<p style="font-size:11px;color:#ff4d6a;margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label style="font-size:12px;font-weight:500;color:var(--text-2);display:block;margin-bottom:6px;">Email Address *</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="you@example.com"
                        style="width:100%;background:var(--bg-3);border:1px solid var(--border-2);border-radius:8px;padding:10px 14px;font-size:13px;color:var(--text);outline:none;font-family:var(--font);"
                        onfocus="this.style.borderColor='var(--accent)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                    @error('email')<p style="font-size:11px;color:#ff4d6a;margin-top:4px;">{{ $message }}</p>@enderror
                </div>
            </div>

            <div style="margin-bottom:14px;">
                <label style="font-size:12px;font-weight:500;color:var(--text-2);display:block;margin-bottom:6px;">Subject *</label>
                <input type="text" name="subject" required value="{{ old('subject') }}" placeholder="How can we help?"
                    style="width:100%;background:var(--bg-3);border:1px solid var(--border-2);border-radius:8px;padding:10px 14px;font-size:13px;color:var(--text);outline:none;font-family:var(--font);"
                    onfocus="this.style.borderColor='var(--accent)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                @error('subject')<p style="font-size:11px;color:#ff4d6a;margin-top:4px;">{{ $message }}</p>@enderror
            </div>

            <div style="margin-bottom:20px;">
                <label style="font-size:12px;font-weight:500;color:var(--text-2);display:block;margin-bottom:6px;">Message *</label>
                <textarea name="message" required rows="5" placeholder="Tell us more..."
                    style="width:100%;background:var(--bg-3);border:1px solid var(--border-2);border-radius:8px;padding:10px 14px;font-size:13px;color:var(--text);outline:none;font-family:var(--font);resize:vertical;"
                    onfocus="this.style.borderColor='var(--accent)'" onblur="this.style.borderColor='rgba(255,255,255,0.1)'">{{ old('message') }}</textarea>
                @error('message')<p style="font-size:11px;color:#ff4d6a;margin-top:4px;">{{ $message }}</p>@enderror
            </div>

            <button type="submit"
                style="width:100%;padding:12px;background:var(--accent);color:white;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;font-family:var(--font);transition:all 0.2s;"
                onmouseover="this.style.opacity='0.88';this.style.transform='translateY(-1px)'"
                onmouseout="this.style.opacity='1';this.style.transform='translateY(0)'">
                Send Message
            </button>
        </form>
    </div>
</section>
@endsection

@extends('admin.layout')
@section('title', 'Message')

@section('content')
<div class="page-header" style="display:flex;align-items:center;justify-content:space-between;">
    <div>
        <h1 class="page-title">Message</h1>
        <p class="page-sub">Viewing contact submission</p>
    </div>
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-ghost btn-sm">← Back</a>
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:16px;align-items:start;">

    {{-- Main Message --}}
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:14px;overflow:hidden;">
        <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;">
            <div style="width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,var(--accent),#a78bfa);display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:700;color:white;flex-shrink:0;">
                {{ strtoupper(substr($message->name, 0, 1)) }}
            </div>
            <div>
                <p style="font-size:14px;font-weight:600;">{{ $message->name }}</p>
                <p style="font-size:12px;color:var(--text-muted);">{{ $message->email }}</p>
            </div>
            <div style="margin-left:auto;">
                <span style="font-size:12px;color:var(--text-muted);">{{ $message->created_at->format('d M Y, h:i A') }}</span>
            </div>
        </div>

        <div style="padding:20px;">
            <div style="margin-bottom:20px;">
                <p style="font-size:10px;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-muted);margin-bottom:6px;">Subject</p>
                <p style="font-size:16px;font-weight:600;">{{ $message->subject }}</p>
            </div>
            <div style="height:1px;background:var(--border);margin-bottom:20px;"></div>
            <div>
                <p style="font-size:10px;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-muted);margin-bottom:10px;">Message</p>
                <p style="font-size:14px;line-height:1.8;color:var(--text-2,var(--text-muted));">{{ $message->message }}</p>
            </div>
        </div>
        {{-- Reply History --}}
        @if($message->replies && count($message->replies) > 0)
        <div style="margin-bottom:16px;">
            <p style="font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-muted);margin-bottom:10px;">Reply History ({{ count($message->replies) }})</p>
            <div style="display:flex;flex-direction:column;gap:8px;">
                @foreach($message->replies as $reply)
                <div style="background:var(--bg-hover);border:1px solid var(--border);border-left:3px solid var(--accent);border-radius:0 8px 8px 0;padding:12px 14px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                        <span style="font-size:11px;font-weight:600;color:var(--accent);">{{ $reply['sent_by'] ?? 'Admin' }}</span>
                        <span style="font-size:11px;color:var(--text-muted);">{{ $reply['sent_at'] ?? '' }}</span>
                    </div>
                    <p style="font-size:13px;color:var(--text);line-height:1.6;margin:0;white-space:pre-line;">{{ $reply['message'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        <div style="padding:16px 20px;border-top:1px solid var(--border);">

            @if(session('reply_sent'))
            <div style="background:rgba(32,212,160,0.08);border:1px solid rgba(32,212,160,0.2);border-radius:8px;padding:12px 16px;margin-bottom:16px;font-size:13px;color:#20d4a0;display:flex;align-items:center;gap:8px;">
                ✓ {{ session('reply_sent') }}
            </div>
            @endif

            <p style="font-size:12px;font-weight:600;margin-bottom:12px;color:var(--text);">Reply to {{ $message->name }}</p>

            <form method="POST" action="{{ route('admin.contacts.reply', $message->id) }}">
                @csrf
                <textarea name="reply_message" rows="4"
                    placeholder="Type your reply here..."
                    required
                    style="width:100%;background:var(--bg-hover);border:1px solid var(--border);border-radius:8px;padding:12px;color:var(--text);font-family:var(--font);font-size:13px;resize:vertical;outline:none;margin-bottom:12px;line-height:1.6;"
                    onfocus="this.style.borderColor='var(--accent)'"
                    onblur="this.style.borderColor='var(--border)'"></textarea>
                <button type="submit" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    Send Reply
                </button>
            </form>

            <form method="POST" action="{{ route('admin.contacts.destroy', $message->id) }}" style="margin-top:10px;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Delete this message?')">Delete</button>
            </form>

        </div>
    </div>

    {{-- Sidebar Info --}}
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:14px;padding:18px;">
        <p style="font-size:12px;font-weight:600;margin-bottom:14px;">Sender Info</p>
        <div style="display:flex;flex-direction:column;gap:12px;">
            <div>
                <p style="font-size:10px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:3px;">Name</p>
                <p style="font-size:13px;font-weight:500;">{{ $message->name }}</p>
            </div>
            <div>
                <p style="font-size:10px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:3px;">Email</p>
                <a href="mailto:{{ $message->email }}" style="font-size:13px;color:var(--accent);">{{ $message->email }}</a>
            </div>
            <div>
                <p style="font-size:10px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:3px;">Received</p>
                <p style="font-size:13px;">{{ $message->created_at->format('d M Y') }}</p>
                <p style="font-size:11px;color:var(--text-muted);">{{ $message->created_at->format('h:i A') }}</p>
            </div>
            <div>
                <p style="font-size:10px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:6px;">Status</p>
                <span style="display:inline-flex;align-items:center;gap:4px;background:rgba(32,212,160,0.08);color:#20d4a0;border:1px solid rgba(32,212,160,0.2);border-radius:20px;padding:3px 10px;font-size:11px;">
                    ✓ Read
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

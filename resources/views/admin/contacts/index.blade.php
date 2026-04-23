@extends('admin.layout')
@section('title', 'Contact Messages')

@section('content')
<div class="page-header" style="display:flex;align-items:center;justify-content:space-between;">
    <div>
        <h1 class="page-title">Contact Messages</h1>
        <p class="page-sub">
            @if($unread > 0)
                <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(91,127,255,0.1);color:var(--accent);border:1px solid rgba(91,127,255,0.2);border-radius:20px;padding:2px 10px;font-size:11px;font-weight:500;">
                    {{ $unread }} unread
                </span>
            @else
                All caught up ✓
            @endif
        </p>
    </div>
</div>

@if(session('success'))
<div style="background:rgba(32,212,160,0.08);border:1px solid rgba(32,212,160,0.2);border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#20d4a0;display:flex;align-items:center;gap:8px;">
    ✓ {{ session('success') }}
</div>
@endif

<div style="background:var(--bg-card);border:1px solid var(--border);border-radius:14px;overflow:hidden;">
    @if($messages->isEmpty())
    <div style="padding:64px 20px;text-align:center;">
        <div style="width:52px;height:52px;border-radius:14px;background:var(--bg-hover);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:22px;margin:0 auto 16px;">✉️</div>
        <p style="font-size:14px;font-weight:600;margin-bottom:6px;">No messages yet</p>
        <p style="font-size:13px;color:var(--text-muted);">Messages from your contact form will appear here</p>
    </div>
    @else
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:1px solid var(--border);">
                    <th style="padding:12px 18px;text-align:left;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;white-space:nowrap;">Sender</th>
                    <th style="padding:12px 18px;text-align:left;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;">Subject</th>
                    <th style="padding:12px 18px;text-align:left;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;white-space:nowrap;">Date</th>
                    <th style="padding:12px 18px;text-align:left;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;">Status</th>
                    <th style="padding:12px 18px;text-align:right;font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $msg)
                <tr style="border-bottom:1px solid var(--border);{{ !$msg->is_read ? 'background:rgba(91,127,255,0.02)' : '' }}" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='{{ !$msg->is_read ? 'rgba(91,127,255,0.02)' : '' }}'">
                    <td style="padding:14px 18px;">
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:8px;background:linear-gradient(135deg,var(--accent),#a78bfa);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:white;flex-shrink:0;">
                                {{ strtoupper(substr($msg->name, 0, 1)) }}
                            </div>
                            <div>
                                <p style="font-size:13px;font-weight:{{ !$msg->is_read ? '600' : '500' }};margin-bottom:1px;">{{ $msg->name }}</p>
                                <p style="font-size:11px;color:var(--text-muted);">{{ $msg->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td style="padding:14px 18px;font-size:13px;max-width:260px;">
                        <span style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;{{ !$msg->is_read ? 'font-weight:500' : 'color:var(--text-muted)' }}">
                            {{ Str::limit($msg->subject, 45) }}
                        </span>
                    </td>
                    <td style="padding:14px 18px;font-size:12px;color:var(--text-muted);white-space:nowrap;">
                        {{ $msg->created_at->diffForHumans() }}
                    </td>
                    <td style="padding:14px 18px;">
                        @if(!$msg->is_read)
                            <span style="display:inline-flex;align-items:center;gap:4px;background:rgba(91,127,255,0.1);color:var(--accent);border:1px solid rgba(91,127,255,0.2);border-radius:20px;padding:3px 10px;font-size:11px;font-weight:500;">
                                <span style="width:5px;height:5px;border-radius:50%;background:var(--accent);"></span> Unread
                            </span>
                        @else
                            <span style="display:inline-flex;align-items:center;gap:4px;background:rgba(255,255,255,0.04);color:var(--text-muted);border:1px solid var(--border);border-radius:20px;padding:3px 10px;font-size:11px;">
                                Read
                            </span>
                        @endif
                    </td>
                    <td style="padding:14px 18px;">
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:6px;">
                            <a href="{{ route('admin.contacts.show', $msg->id) }}" class="btn btn-sm btn-ghost">View</a>
                            <form method="POST" action="{{ route('admin.contacts.destroy', $msg->id) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this message?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($messages->hasPages())
    <div style="padding:14px 18px;border-top:1px solid var(--border);">
        {{ $messages->links() }}
    </div>
    @endif
    @endif
</div>
@endsection

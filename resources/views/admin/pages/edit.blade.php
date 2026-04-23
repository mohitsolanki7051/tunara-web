@extends('admin.layout')
@section('title', 'Edit ' . $title)

@section('content')
<div class="page-header" style="display:flex;align-items:center;justify-content:space-between;">
    <div>
        <h1 class="page-title">{{ $title }}</h1>
        <p class="page-sub">Editing content for <code style="font-size:12px;background:var(--bg-hover);padding:2px 8px;border-radius:4px;color:var(--accent);">/{{ $slug }}</code></p>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="/{{ $slug }}" target="_blank" class="btn btn-ghost btn-sm">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            Preview
        </a>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-ghost btn-sm">← Back</a>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start;">

    {{-- Editor --}}
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:14px;overflow:hidden;">
        <div style="padding:14px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;">
            <span style="font-size:13px;font-weight:600;">Content Editor</span>
            <span style="font-size:11px;color:var(--text-muted);">HTML supported</span>
        </div>
        <form method="POST" action="{{ route('admin.pages.update', $slug) }}" id="page-form">
            @csrf
            <div style="padding:18px;">
                <textarea name="content" id="content-editor" rows="24"
                    style="width:100%;background:var(--bg-input,var(--bg-hover));border:1px solid var(--border);border-radius:8px;padding:14px;color:var(--text);font-family:var(--mono);font-size:13px;resize:vertical;outline:none;line-height:1.7;"
                    onfocus="this.style.borderColor='var(--accent)'"
                    onblur="this.style.borderColor='var(--border)'"
                    placeholder="Enter page content here. HTML tags are supported.&#10;&#10;Example:&#10;&lt;h2&gt;About Us&lt;/h2&gt;&#10;&lt;p&gt;We are a team of developers...&lt;/p&gt;">{{ $content }}</textarea>
                @error('content')
                <p style="font-size:12px;color:#ff4d6a;margin-top:6px;">{{ $message }}</p>
                @enderror
            </div>
            <div style="padding:14px 18px;border-top:1px solid var(--border);display:flex;gap:10px;">
                <button type="submit" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Save Changes
                </button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>

    {{-- Sidebar Tips --}}
    <div style="display:flex;flex-direction:column;gap:12px;">
        <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:14px;padding:18px;">
            <p style="font-size:12px;font-weight:600;margin-bottom:12px;color:var(--text);">HTML Quick Reference</p>
            <div style="display:flex;flex-direction:column;gap:8px;">
                @foreach([
                    ['tag' => '<h2>Heading</h2>', 'desc' => 'Section heading'],
                    ['tag' => '<p>Paragraph</p>', 'desc' => 'Body text'],
                    ['tag' => '<strong>Bold</strong>', 'desc' => 'Bold text'],
                    ['tag' => '<ul><li>Item</li></ul>', 'desc' => 'Bullet list'],
                    ['tag' => '<a href="#">Link</a>', 'desc' => 'Hyperlink'],
                    ['tag' => '<br>', 'desc' => 'Line break'],
                ] as $ref)
                <div style="background:var(--bg-hover);border-radius:6px;padding:8px 10px;">
                    <code style="font-size:10px;color:var(--accent);font-family:var(--mono);display:block;margin-bottom:2px;">{{ $ref['tag'] }}</code>
                    <span style="font-size:11px;color:var(--text-muted);">{{ $ref['desc'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div style="background:rgba(91,127,255,0.06);border:1px solid rgba(91,127,255,0.15);border-radius:14px;padding:18px;">
            <p style="font-size:12px;font-weight:600;margin-bottom:8px;">💡 Tips</p>
            <ul style="font-size:12px;color:var(--text-muted);line-height:1.7;padding-left:14px;">
                <li>Use HTML for formatting</li>
                <li>Preview before saving</li>
                <li>Contact page content appears above the form</li>
            </ul>
        </div>
    </div>
</div>
@endsection

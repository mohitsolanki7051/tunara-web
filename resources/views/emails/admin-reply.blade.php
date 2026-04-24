<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reply from Tunara Support</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f8;font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f8;padding:40px 0;">
  <tr>
    <td align="center">
      <table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

        {{-- Header --}}
        <tr>
          <td style="background:linear-gradient(135deg,#5b7fff,#a78bfa);padding:36px 40px;text-align:center;">
            <div>
              <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#10d98a;margin-right:6px;vertical-align:middle;"></span>
              <span style="font-size:20px;font-weight:700;color:#ffffff;letter-spacing:-0.02em;vertical-align:middle;">Tunara</span>
            </div>
            <p style="color:rgba(255,255,255,0.75);font-size:13px;margin:8px 0 0;">Support Team</p>
          </td>
        </tr>

        {{-- Body --}}
        <tr>
          <td style="padding:40px;">

            <p style="font-size:15px;color:#1a1a2e;margin:0 0 6px;font-weight:600;">Hi {{ $userName }},</p>
            <p style="font-size:14px;color:#6b7280;margin:0 0 24px;line-height:1.7;">Our support team has responded to your message. Here's what they said:</p>

            {{-- Original Subject --}}
            <p style="font-size:13px;color:#6b7280;margin:0 0 6px;">In response to your message:</p>
            <p style="font-size:14px;font-weight:600;color:#1a1a2e;margin:0 0 20px;">{{ $originalSubject }}</p>

            {{-- Reply Message --}}
            <div style="background:#f8f8ff;border-left:3px solid #5b7fff;border-radius:0 12px 12px 0;padding:20px 22px;margin-bottom:28px;">
              <p style="font-size:13px;font-weight:600;color:#1a1a2e;margin:0 0 10px;">Tunara Support</p>
              <p style="font-size:14px;color:#374151;line-height:1.8;margin:0;white-space:pre-line;">{{ $replyMessage }}</p>
            </div>

            {{-- Note --}}
            <div style="background:#f0fdf4;border-left:3px solid #10d98a;border-radius:0 8px 8px 0;padding:12px 16px;">
              <p style="font-size:12px;color:#166534;margin:0;">
                💬 To reply, simply respond to this email or visit our <a href="https://www.tunara.online/contact" style="color:#5b7fff;">contact page</a>.
              </p>
            </div>
          </td>
        </tr>

        {{-- Footer --}}
        <tr>
          <td style="background:#f8f8ff;padding:24px 40px;border-top:1px solid #e5e7eb;text-align:center;">
            <p style="font-size:12px;color:#9ca3af;margin:0 0 6px;">
              © {{ date('Y') }} Tunara ·
              <a href="https://www.tunara.online" style="color:#5b7fff;text-decoration:none;">www.tunara.online</a>
            </p>
            <p style="font-size:11px;color:#d1d5db;margin:0;">This is a reply to your contact form submission on Tunara.</p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>

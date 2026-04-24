<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thank You for Your Review</title>
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
            <p style="color:rgba(255,255,255,0.75);font-size:13px;margin:8px 0 0;">Localhost Tunneling Platform</p>
          </td>
        </tr>

        {{-- Body --}}
        <tr>
          <td style="padding:40px;">

            {{-- Thank You Icon --}}
            <div style="text-align:center;margin-bottom:28px;">
              <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,rgba(91,127,255,0.1),rgba(167,139,250,0.1));border:2px solid rgba(91,127,255,0.2);display:inline-flex;align-items:center;justify-content:center;font-size:32px;line-height:72px;">
                🌟
              </div>
            </div>

            <h1 style="font-size:22px;font-weight:700;color:#1a1a2e;text-align:center;margin:0 0 10px;letter-spacing:-0.02em;">Thank you, {{ $userName }}!</h1>
            <p style="font-size:14px;color:#6b7280;text-align:center;line-height:1.7;margin:0 0 28px;">Your review means a lot to us. We truly appreciate you taking the time to share your experience with the Tunara community.</p>

            {{-- Divider --}}
            <div style="height:1px;background:linear-gradient(90deg,transparent,#e5e7eb,transparent);margin:0 0 28px;"></div>

            {{-- Message --}}
            <div style="background:#f8f8ff;border-radius:12px;padding:24px;margin-bottom:28px;">
              <p style="font-size:13px;color:#6b7280;margin:0 0 12px;">Your review helps other developers discover Tunara and make informed decisions. Once our team reviews and approves it, it will be featured on our website.</p>
              <p style="font-size:13px;color:#6b7280;margin:0;">In the meantime, keep building amazing things! 🚀</p>
            </div>

            {{-- CTA --}}
            <div style="text-align:center;margin-bottom:28px;">
              <a href="https://www.tunara.online/dashboard" style="display:inline-block;background:linear-gradient(135deg,#5b7fff,#a78bfa);color:#ffffff;font-size:14px;font-weight:600;padding:13px 32px;border-radius:10px;text-decoration:none;">Go to Dashboard →</a>
            </div>

            {{-- Security Note --}}
            <div style="background:#fff8f0;border-left:3px solid #f97316;border-radius:0 8px 8px 0;padding:12px 16px;">
              <p style="font-size:12px;color:#92400e;margin:0;">
                💡 Not you? If you didn't submit a review on Tunara, please ignore this email.
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
            <p style="font-size:11px;color:#d1d5db;margin:0;">You received this because you submitted a review on Tunara.</p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>

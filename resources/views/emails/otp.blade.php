<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify your email</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f8;font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f8;padding:40px 0;">
  <tr>
    <td align="center">
      <table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.08);">

        {{-- Header --}}
        <tr>
          <td style="background:linear-gradient(135deg,#5b7fff,#a78bfa);padding:36px 40px;text-align:center;">
            <div style="display:inline-flex;align-items:center;gap:8px;">
              <div style="width:8px;height:8px;border-radius:50%;background:#10d98a;display:inline-block;"></div>
              <span style="font-size:20px;font-weight:700;color:#ffffff;letter-spacing:-0.02em;">Tunara</span>
            </div>
            <p style="color:rgba(255,255,255,0.75);font-size:13px;margin:8px 0 0;">Localhost Tunneling Platform</p>
          </td>
        </tr>

        {{-- Body --}}
        <tr>
          <td style="padding:40px;">
            <p style="font-size:15px;color:#1a1a2e;margin:0 0 8px;">Hi {{ $userName }},</p>
            <p style="font-size:14px;color:#6b7280;line-height:1.7;margin:0 0 32px;">
              Thanks for signing up for Tunara! Please use the verification code below to confirm your email address and activate your account.
            </p>

            {{-- OTP Box --}}
            <div style="background:#f8f8ff;border:2px dashed #5b7fff;border-radius:12px;padding:28px;text-align:center;margin-bottom:32px;">
              <p style="font-size:12px;font-weight:600;color:#5b7fff;letter-spacing:0.1em;text-transform:uppercase;margin:0 0 12px;">Your verification code</p>
              <div style="font-size:42px;font-weight:800;letter-spacing:0.15em;color:#1a1a2e;font-family:'Courier New',monospace;">{{ $otp }}</div>
              <p style="font-size:12px;color:#9ca3af;margin:12px 0 0;">⏱ This code expires in <strong>10 minutes</strong></p>
            </div>

            <p style="font-size:13px;color:#9ca3af;line-height:1.7;margin:0 0 24px;">
              If you didn't create a Tunara account, you can safely ignore this email. Someone may have entered your email address by mistake.
            </p>

            <div style="background:#fff8f0;border-left:3px solid #f97316;border-radius:0 8px 8px 0;padding:12px 16px;">
              <p style="font-size:12px;color:#92400e;margin:0;">
                🔒 Never share this code with anyone. Tunara will never ask for your OTP via phone or chat.
              </p>
            </div>
          </td>
        </tr>

        {{-- Footer --}}
        <tr>
          <td style="background:#f8f8ff;padding:24px 40px;border-top:1px solid #e5e7eb;text-align:center;">
            <p style="font-size:12px;color:#9ca3af;margin:0 0 6px;">
              © {{ date('Y') }} Tunara · <a href="https://www.tunara.online" style="color:#5b7fff;text-decoration:none;">www.tunara.online</a>
            </p>
            <p style="font-size:11px;color:#d1d5db;margin:0;">
              You're receiving this because you signed up at Tunara.
            </p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>

</body>
</html>

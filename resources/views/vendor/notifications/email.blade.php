
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gemarc Notification</title>
</head>
<body style="background:#181b1f; margin:0; padding:0; font-family:Arial,sans-serif; color:#222;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#181b1f; min-height:100vh;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:480px; background:#fff; border-radius:16px; margin:32px auto; box-shadow:0 2px 12px #0002;">
                    <tr>
                        <td style="text-align:center; padding:32px 32px 16px 32px;">
                            <img src="https://res.cloudinary.com/dytjw8uya/image/upload/v1758531199/gemarclogo_ayrwn8.png" alt="Gemarc Enterprises Inc." style="max-width:160px; margin-bottom:8px; display:block; margin-left:auto; margin-right:auto;">
                            <div style="font-size:1.2rem; font-weight:bold; color:#1db954; margin-top:4px;">Gemarc Enterprises Inc. E-commerce</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 32px 16px 32px;">
                            <h2 style="margin:0 0 12px 0; color:#222; font-size:1.5rem;">@if (!empty($greeting)) {{ $greeting }} @else @if ($level === 'error') Whoops! @else Hello! @endif @endif</h2>
                            @foreach ($introLines as $line)
                                <p style="margin:0 0 16px 0; color:#222; font-size:1rem;">{{ $line }}</p>
                            @endforeach
                            @isset($actionText)
                                <?php
                                    $color = match ($level) {
                                        'success' => '#1db954', // green
                                        'error' => '#ff4d4f',   // red
                                        default => '#ff9900',   // orange
                                    };
                                ?>
                                <div style="text-align:center; margin:32px 0 24px 0;">
                                    <a href="{{ $actionUrl }}" style="background:{{ $color }};color:#fff;padding:14px 32px;border-radius:8px;text-decoration:none;font-weight:bold;font-size:1rem;display:inline-block;">{{ $actionText }}</a>
                                </div>
                            @endisset
                            @foreach ($outroLines as $line)
                                <p style="margin:0 0 16px 0; color:#222; font-size:1rem;">{{ $line }}</p>
                            @endforeach
                            <p style="margin:32px 0 0 0; color:#222;">@if (!empty($salutation)) {{ $salutation }} @else Best regards,<br><span style="color:#1db954; font-weight:bold;">Gemarc Enterprises Inc.</span> @endif</p>
                        </td>
                    </tr>
                    @isset($actionText)
                    <tr>
                        <td style="padding:0 32px 32px 32px;">
                            <p style="font-size:0.95rem; color:#888; margin:0;">If you're having trouble clicking the <b>{{ $actionText }}</b> button, copy and paste the URL below into your web browser:</p>
                            <p style="word-break:break-all; color:#1db954; font-size:0.95rem; margin:8px 0 0 0;">{{ $displayableActionUrl ?? $actionUrl }}</p>
                        </td>
                    </tr>
                    @endisset
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

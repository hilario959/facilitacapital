<!doctype html>
<html lang="es">
<body style="margin:0;background:#f4f7f4;font-family:Arial,sans-serif;color:#0e0f0c;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f7f4;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;background:#ffffff;border-radius:16px;overflow:hidden;">
                    <tr>
                        <td style="background:#163300;padding:28px 32px;color:#ffffff;">
                            <p style="margin:0;font-size:13px;letter-spacing:0.14em;text-transform:uppercase;color:#c6ff4d;">Facilita Capital</p>
                            <h1 style="margin:10px 0 0;font-size:24px;line-height:1.2;">{{ $greeting }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px 32px;font-size:16px;line-height:1.6;color:#454745;">
                            <p style="margin:0 0 16px;">{{ $body }}</p>
                            <p style="margin:0;padding:16px;background:#e8fff1;border-radius:12px;color:#0e0f0c;">
                                Facturas: <strong>{{ \App\Support\Finance::money($lead->invoice_amount) }}</strong><br>
                                Plazo: <strong>{{ $lead->term_days }} días</strong><br>
                                Estimado para hoy: <strong>{{ \App\Support\Finance::money($lead->payout_amount) }}</strong>
                            </p>
                            <p style="margin:24px 0 0;color:#0e0f0c;font-weight:700;">{{ $closing }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

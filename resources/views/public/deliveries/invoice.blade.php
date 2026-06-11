<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $delivery->id }} - DigitalSpace</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.6; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); }
        .header { display: flex; justify-content: space-between; border-bottom: 2px solid #primary; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 28px; font-weight: bold; color: #2563eb; }
        .info { margin-bottom: 40px; }
        .grid { display: flex; justify-content: space-between; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        th { background: #f8fafc; text-align: left; padding: 12px; border-bottom: 2px solid #eee; }
        td { padding: 12px; border-bottom: 1px solid #eee; }
        .total { text-align: right; font-size: 20px; font-weight: bold; }
        .footer { text-align: center; font-size: 12px; color: #94a3b8; margin-top: 50px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <div class="logo">DigitalSpace</div>
            <div style="text-align: right">
                <h2 style="margin: 0">FACTURE</h2>
                <p style="margin: 0">#INV-SR-{{ $delivery->id }}</p>
                <p style="margin: 0">Date: {{ $delivery->updated_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="grid" style="display: flex; gap: 50px; margin-bottom: 40px;">
            <div style="flex: 1">
                <p style="font-weight: bold; margin-bottom: 5px;">De:</p>
                <p style="margin: 0">DigitalSpace Agency</p>
                <p style="margin: 0">Ouagadougou, Zone 1</p>
                <p style="margin: 0">contact@digitalspace.com</p>
            </div>
            <div style="flex: 1; text-align: right">
                <p style="font-weight: bold; margin-bottom: 5px;">À:</p>
                <p style="margin: 0">{{ $delivery->serviceRequest->client_name }}</p>
                <p style="margin: 0">{{ $delivery->serviceRequest->client_email }}</p>
                <p style="margin: 0">{{ $delivery->serviceRequest->client_phone }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description du Service</th>
                    <th style="text-align: right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $delivery->title }}</strong><br>
                        <small>{{ $delivery->serviceRequest->service_type }} - {{ Str::limit($delivery->description, 100) }}</small>
                    </td>
                    <td style="text-align: right">{{ number_format($delivery->price, 2) }} €</td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            Total Payé: {{ number_format($delivery->price, 2) }} €
        </div>

        <div class="footer">
            <p>Merci pour votre confiance !</p>
            <p>Cette facture a été générée électroniquement et est considérée comme payée.</p>
            <p>DigitalSpace - Votre partenaire de transformation numérique.</p>
        </div>
    </div>

    <div style="text-align: center; margin-top: 20px; no-print">
        <button onclick="window.print()" style="padding: 10px 20px; background: #2563eb; color: white; border: none; border-radius: 5px; cursor: pointer;">Imprimer la facture</button>
    </div>
</body>
</html>

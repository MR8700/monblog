<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background: #0066cc; color: white; padding: 20px; border-radius: 10px 10px 0 0; text-align: center; }
        .content { padding: 20px; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #666; font-size: 12px; text-transform: uppercase; }
        .value { font-size: 16px; margin-top: 5px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Nouveau Message</h1>
        </div>
        <div class="content">
            <div class="field">
                <div class="label">Expéditeur</div>
                <div class="value">{{ $contactMessage->name }} ({{ $contactMessage->email }})</div>
            </div>
            <div class="field">
                <div class="label">Objet</div>
                <div class="value">{{ $contactMessage->subject ?? 'Non spécifié' }}</div>
            </div>
            <div class="field">
                <div class="label">Message</div>
                <div class="value" style="background: #f9f9f9; padding: 15px; border-radius: 5px; white-space: pre-wrap;">{{ $contactMessage->message }}</div>
            </div>
        </div>
        <div class="footer">
            Cet email a été envoyé via le formulaire de contact de DigitalSpace.
        </div>
    </div>
</body>
</html>

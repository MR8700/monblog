<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background: #0066cc; color: white; padding: 20px; border-radius: 10px 10px 0 0; text-align: center; }
        .content { padding: 20px; }
        .reply-box { background: #f0f7ff; padding: 20px; border-radius: 10px; border-left: 4px solid #0066cc; margin-bottom: 20px; }
        .original-message { font-size: 13px; color: #777; border-top: 1px solid #eee; padding-top: 20px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>DigitalSpace</h1>
        </div>
        <div class="content">
            <p>Bonjour {{ $contactMessage->name }},</p>
            <p>Nous avons bien reçu votre message et voici notre réponse :</p>
            
            <div class="reply-box">
                {!! nl2br(e($contactMessage->admin_reply)) !!}
            </div>

            <p>Nous restons à votre entière disposition pour toute information complémentaire.</p>
            
            <div class="original-message">
                <strong>Votre message original :</strong><br>
                <em>"{{ $contactMessage->message }}"</em>
            </div>
        </div>
        <div class="footer">
            Cordialement,<br>
            L'équipe DigitalSpace
        </div>
    </div>
</body>
</html>

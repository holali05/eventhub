<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { padding: 20px; border: 1px solid #eee; border-radius: 5px; max-width: 600px; margin: 0 auto; }
        .header { background-color: #4f46e5; color: white; padding: 10px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { padding: 20px; }
        .footer { font-size: 12px; color: #777; margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Votre billet EventHub</h2>
        </div>
        <div class="content">
            <p>Bonjour <strong>{{ $ticket->customer_name }}</strong>,</p>
            
            <p>Merci pour votre achat ! Votre réservation pour l'événement <strong>{{ $ticket->ticketType->event->title }}</strong> a été confirmée.</p>
            
            <p>Vous trouverez votre ticket avec son <strong>code QR unique</strong> en pièce jointe de cet email.</p>
            
            <p><strong>Détails de l'événement :</strong><br>
            📅 Date : {{ \Carbon\Carbon::parse($ticket->ticketType->event->event_date)->format('d/m/Y') }}<br>
            📍 Lieu : {{ $ticket->ticketType->event->location }}</p>
            
            <p>Veuillez présenter ce ticket (sur votre téléphone ou imprimé) à l'entrée de l'événement pour validation.</p>
            
            <p>À très bientôt,<br>
            L'équipe EventHub</p>
        </div>
        <div class="footer">
            Ceci est un message automatique, merci de ne pas y répondre directement.
        </div>
    </div>
</body>
</html>
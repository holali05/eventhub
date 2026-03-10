<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            line-height: 1.6;
            color: #1e293b;
            background-color: #fafaf8;
            padding: 40px;
        }

        .card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 10px 40px -10px rgba(237, 51, 20, 0.1);
            border: 1px solid #ffe8e3;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            color: #ed3314;
            font-size: 28px;
            font-weight: 800;
            text-decoration: none;
        }

        h1 {
            color: #0f172a;
            margin-top: 0;
        }

        .event-info {
            background: #fff5f0;
            border-radius: 16px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #ed3314;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #94a3b8;
        }

        .btn {
            display: inline-block;
            background: #ed3314;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="header">
            <a href="#" class="logo">EventHub</a>
        </div>

        <h1>Merci pour votre réservation !</h1>
        <p>Bonjour {{ $booking->user_name }},</p>
        <p>Votre réservation pour l'événement <strong>{{ $booking->event->title }}</strong> est confirmée.</p>

        <div class="event-info">
            <p style="margin: 0; font-weight: bold;">Détails de la réservation :</p>
            <ul style="list-style: none; padding: 0;">
                <li>📅 Date : {{ \Carbon\Carbon::parse($booking->event->event_date)->translatedFormat('d M Y') }}</li>
                <li>📍 Lieu : {{ $booking->event->location }}</li>
                <li>🎟️ Type de ticket : {{ $booking->ticketType->name }}</li>
                <li>👥 Places : {{ $booking->tickets_count }}</li>
            </ul>
        </div>

        <p>Vous pouvez retrouver vos billets à tout moment dans votre espace personnel sur EventHub.</p>

        <div style="text-align: center;">
            <a href="{{ route('bookings.index') }}" class="btn">Voir mes réservations</a>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} EventHub. Cet email a été envoyé automatiquement.
        </div>
    </div>
</body>

</html>
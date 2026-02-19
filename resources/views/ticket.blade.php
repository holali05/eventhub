<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket - {{ $ticket->ticketType->event->title }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; }
        .ticket-container {
            width: 100%;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }
        .header {
            background-color: #4f46e5;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        
        .content {
            padding: 20px;
            position: relative;
        }
        .event-info { width: 70%; float: left; }
        .qr-section { width: 25%; float: right; text-align: right; }
        
        .label { color: #64748b; font-size: 12px; text-transform: uppercase; margin-top: 10px; }
        .value { font-size: 16px; font-weight: bold; margin-bottom: 5px; }

        .footer {
            clear: both;
            background-color: #f8fafc;
            padding: 15px 20px;
            border-top: 1px dashed #cbd5e1;
            font-size: 12px;
            color: #64748b;
        }
        .price-tag {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .clear { clear: both; }
    </style>
</head>
<body>

    <div class="ticket-container">
        <!-- En-tête -->
        <div class="header">
            <h1>{{ $ticket->ticketType->event->title }}</h1>
        </div>

        <div class="content">
            <div class="event-info">
                <div class="label">Acheteur</div>
                <div class="value">{{ $ticket->customer_name }}</div>

                <div class="label">Type de Billet</div>
                <div class="value">
                    {{ $ticket->ticketType->name }} 
                    <span class="price-tag">{{ number_format($ticket->ticketType->price, 0, ',', ' ') }} FCFA</span>
                </div>

                <div class="label">Date & Heure</div>
                <div class="value">
                    {{ \Carbon\Carbon::parse($ticket->ticketType->event->event_date)->format('d/m/Y') }} 
                    à {{ $ticket->ticketType->event->event_time }}
                </div>

                <div class="label">Lieu</div>
                <div class="value">{{ $ticket->ticketType->event->location }}</div>
            </div>

            <div class="qr-section">
                <!-- Génération du QR Code en Base64 pour qu'il s'affiche dans le PDF -->
                <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(150)->margin(0)->generate($ticket->unique_hash)) }}">
                <div class="label" style="text-align: center;">Scannez-moi</div>
            </div>
            
            <div class="clear"></div>
        </div>

        <div class="footer">
            Ticket unique généré par <strong>EventHub</strong>. 
            Code de sécurité : {{ strtoupper(substr($ticket->unique_hash, 0, 8)) }}...
            <br>
            <i>Présentez ce ticket à l'entrée. Une pièce d'identité peut être demandée.</i>
        </div>
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Billet - {{ $ticket->ticketType->event->title }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f5f9;
        }

        .ticket-wrapper {
            position: relative;
            width: 210mm;
            height: 297mm;
            background-color: #ffffff;
            overflow: hidden;
        }

        /* Fond personnalisé ou dégradé par défaut */
        .ticket-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            @if($ticket->ticketType->event->ticket_template_path)
                background-image: url('{{ public_path($ticket->ticketType->event->ticket_template_path) }}');
                background-size: cover;
                background-position: center;
            @else background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            @endif
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 2;
        }

        .ticket-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 160mm;
            background: #ffffff;
            border-radius: 40px;
            overflow: hidden;
            box-shadow: 0 50px 100px rgba(0, 0, 0, 0.3);
            z-index: 3;
        }

        .header {
            background: #0f172a;
            color: white;
            padding: 40px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 4px;
            font-weight: 900;
        }

        .body {
            padding: 50px;
            position: relative;
        }

        .info-grid {
            width: 100%;
        }

        .info-item {
            margin-bottom: 30px;
        }

        .label {
            color: #94a3b8;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .value {
            font-size: 20px;
            font-weight: 900;
            color: #1e293b;
            text-transform: uppercase;
        }

        .qr-card {
            background: #f8fafc;
            border-radius: 30px;
            padding: 30px;
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        .price-badge {
            display: inline-block;
            background: #4f46e5;
            color: white;
            padding: 8px 20px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: 900;
            margin-top: 10px;
        }

        .footer {
            background: #f8fafc;
            padding: 30px 50px;
            border-top: 2px dashed #e2e8f0;
            text-align: center;
            font-size: 10px;
            color: #64748b;
            font-weight: 600;
        }

        .logo {
            font-size: 24px;
            font-weight: 900;
            color: #4f46e5;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="ticket-wrapper">
        <div class="ticket-background"></div>
        <div class="overlay"></div>

        <div class="ticket-content">
            <div class="header">
                <h1>{{ $ticket->ticketType->event->title }}</h1>
            </div>

            <div class="body">
                <table class="info-grid">
                    <tr>
                        <td style="width: 60%; vertical-align: top;">
                            <div class="info-item">
                                <div class="label">Détenteur du billet</div>
                                <div class="value">{{ $ticket->customer_name }}</div>
                            </div>

                            <div class="info-item">
                                <div class="label">Catégorie</div>
                                <div class="value">
                                    {{ $ticket->ticketType->name }}
                                    <br>
                                    <div class="price-badge">
                                        {{ number_format($ticket->ticketType->price, 0, ',', ' ') }} FCFA</div>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="label">Date & Heure</div>
                                <div class="value">
                                    {{ \Carbon\Carbon::parse($ticket->ticketType->event->event_date)->format('d/m/Y') }}
                                    à {{ $ticket->ticketType->event->event_time }}
                                </div>
                            </div>

                            <div class="info-item" style="margin-bottom: 0;">
                                <div class="label">Lieu</div>
                                <div class="value">{{ $ticket->ticketType->event->location }}</div>
                            </div>
                        </td>
                        <td style="width: 40%; text-align: right; vertical-align: top;">
                            <div class="qr-card">
                                <img src="data:image/svg+xml;base64,{{ base64_encode(QrCode::format('svg')->size(160)->margin(0)->generate($ticket->unique_hash)) }}"
                                    style="margin-bottom: 15px;">
                                <div class="label">Scanner pour validation</div>
                                <div style="font-size: 10px; font-weight: 800; color: #1e293b; margin-top: 10px;">ID:
                                    {{ strtoupper(substr($ticket->unique_hash, 0, 8)) }}</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="footer">
                <div class="logo">EventHub</div>
                Ce billet est unique et personnel. Il sera scanné à l'entrée.<br>
                Toute reproduction est interdite. Propulsé par la technologie <strong>EventHub</strong>.
            </div>
        </div>
    </div>

</body>

</html>
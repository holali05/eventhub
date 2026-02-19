<?php

namespace App\Mail;

use App\Models\Ticket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;

    /**
     * Create a new message instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre billet pour ' . $this->ticket->ticketType->event->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket_body', // On va créer cette vue juste après
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        // Génération du PDF en mémoire
        $pdf = Pdf::loadView('ticket', ['ticket' => $this->ticket]);

        return [
            Attachment::fromData(fn () => $pdf->output(), 'MonTicket.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
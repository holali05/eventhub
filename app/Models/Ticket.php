<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés massivement.
     */
    protected $fillable = [
        'ticket_type_id',
        'customer_name',
        'customer_whatsapp',
        'customer_email',
        'unique_hash',
        'is_scanned',
        'scanned_at',
    ];

    /**
     * Les attributs à transformer.
     */
    protected function casts(): array
    {
        return [
            'is_scanned' => 'boolean',
            'scanned_at' => 'datetime',
        ];
    }

    /**
     * Relation : Un ticket appartient à un type de ticket (ex: Ticket #001 est de type "VIP").
     */
    public function ticketType(): BelongsTo
    {
        return $this->belongsTo(TicketType::class);
    }

    /**
     * Accès direct à l'événement via le type de ticket.
     * Utile pour afficher le nom de l'événement sur le billet sans faire de requêtes complexes.
     */
    public function event()
    {
        return $this->ticketType->event();
    }
}
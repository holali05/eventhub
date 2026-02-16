<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappList extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés massivement.
     */
    protected $fillable = [
        'event_id',
        'phone_number',
        'contact_name',
        'frequency',    // Ajouté pour la gestion auto
        'last_sent_at', // Ajouté pour le suivi des envois
        'is_active',    // Ajouté pour pouvoir désactiver un contact
    ];

    /**
     * Cast des attributs.
     */
    protected $casts = [
        'last_sent_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relation : Un contact appartient à un événement spécifique.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
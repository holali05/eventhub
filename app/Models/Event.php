<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés massivement.
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'event_date',
        'event_time',
        'image_path',
    ];

    /**
     * Relation : Un événement appartient à un utilisateur (l'organisateur).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : Un événement peut avoir plusieurs types de tickets (VIP, Standard...).
     */
    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }

    /**
     * Relation : Un événement a une liste de numéros WhatsApp pour les invitations.
     */
    public function whatsappLists(): HasMany
    {
        return $this->hasMany(WhatsappList::class);
    }

    /**
     * Relation : Un événement a plusieurs routines de relance (Daily, Weekly...).
     */
    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }
}
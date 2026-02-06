<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketType extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés massivement.
     */
    protected $fillable = [
        'event_id',
        'name',
        'price',
        'total_quantity',
        'remaining_quantity',
    ];

    /**
     * Relation : Un type de ticket appartient à un événement.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relation : Un type de ticket possède plusieurs billets vendus.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Méthode utile pour vérifier s'il reste des places.
     */
    public function hasAvailablePlaces(): bool
    {
        return $this->remaining_quantity > 0;
    }
}
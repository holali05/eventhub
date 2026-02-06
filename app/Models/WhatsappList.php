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
    ];

    /**
     * Relation : Un contact appartient à un événement spécifique.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
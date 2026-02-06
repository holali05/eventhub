<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reminder extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés massivement.
     */
    protected $fillable = [
        'event_id',
        'message',
        'frequency',
        'last_sent_at',
        'is_active',
    ];

    /**
     * Les attributs à transformer.
     */
    protected function casts(): array
    {
        return [
            'last_sent_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relation : Un rappel appartient à un événement.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
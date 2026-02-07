<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'event_date',
        'event_time',
        'image_path',
        'capacity', 
        'ticket_template_path',
        'is_published',
        'admin_status',
        'rejection_reason',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }

    public function ticketTypes(): HasMany
    {
        return $this->hasMany(TicketType::class);
    }

    
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * STATISTIQUES AUTOMATIQUES
     */

    
    public function getTotalSoldAttribute(): int
    {
       
        return $this->bookings()->sum('tickets_count') ?? 0;
    }

    
    public function getFillRateAttribute(): float
    {
        if ($this->capacity <= 0) return 0;
        
       
        $rate = ($this->total_sold / $this->capacity) * 100;
        
        return round($rate, 2);
    }
}
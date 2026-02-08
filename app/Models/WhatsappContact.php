<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappContact extends Model
{
    protected $fillable = ['event_id', 'phone_number', 'last_reminder_sent_at'];
}
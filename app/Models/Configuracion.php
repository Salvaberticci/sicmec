<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuracions';

    protected $fillable = [
        'twilio_sid',
        'twilio_token',
        'twilio_from',
        'twilio_to_default',
        'telegram_bot_token'
    ];
}

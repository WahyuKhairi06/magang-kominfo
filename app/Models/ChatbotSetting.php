<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatbotSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo_chatbot',
        'ai_name',
        'puskesmas_display_name',
        'greeting_message',
        'primary_color',
        'status',
    ];
}

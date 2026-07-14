<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatbotSettingsSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\ChatbotSetting::updateOrCreate(
            ['id' => 1],
            [
                'ai_name' => 'Asisten Puskesmas',
                'puskesmas_display_name' => 'Puskesmas Marunggi',
                'greeting_message' => 'Halo! Saya adalah Asisten Virtual Puskesmas Marunggi. Ada yang bisa saya bantu hari ini?',
                'primary_color' => '#1e6b4d',
                'status' => 'active',
            ]
        );
    }
}

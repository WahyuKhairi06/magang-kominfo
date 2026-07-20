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
                'greeting_message' => "Halo! Saya adalah **Asisten Puskesmas**, asisten virtual resmi Puskesmas **Puskesmas Marunggi**. Saya siap membantu Anda mendapatkan informasi seputar layanan Puskesmas **Puskesmas Marunggi**. Sebagai AI Assistant yang dikembangkan membantu masyarakat mencari informasi resmi seputar Puskesmas **Puskesmas Marunggi**. Saya bukan manusia dan bukan tenaga medis, sehingga tidak dapat melakukan diagnosis penyakit atau memberikan resep obat. Ada yang bisa saya bantu terkait layanan Puskesmas **Puskesmas Marunggi**?",
                'primary_color' => '#1e6b4d',
                'status' => 'active',
            ]
        );
    }
}

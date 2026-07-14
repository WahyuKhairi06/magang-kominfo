<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chatbot_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo_chatbot', 255)->nullable();
            $table->string('ai_name', 100)->default('Asisten Puskesmas');
            $table->string('puskesmas_display_name', 150)->default('Puskesmas Marunggi')->comment('Nama puskesmas yang akan disinkronisasi ke chatbot');
            $table->text('greeting_message')->nullable();
            $table->string('primary_color', 20)->default('#1e6b4d');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_settings');
    }
};

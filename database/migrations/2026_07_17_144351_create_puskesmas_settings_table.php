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
        Schema::create('puskesmas_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_puskesmas');
            $table->string('kabupaten_kota');
            $table->text('alamat');
            $table->string('no_telp');
            $table->string('email');
            $table->string('logo')->nullable();
            
            // Jam Kerja / Layanan
            $table->string('jam_senin_kamis')->default('08:00 - 14:00');
            $table->string('jam_jumat')->default('08:00 - 11:00');
            $table->string('jam_sabtu')->default('08:00 - 13:00');
            
            // Media Sosial
            $table->string('link_facebook')->nullable();
            $table->string('link_instagram')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puskesmas_settings');
    }
};

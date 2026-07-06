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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
             $table->string('judul_agenda');
    $table->date('tanggal');
    $table->time('jam_mulai')->nullable();
    $table->time('jam_selesai')->nullable();
    $table->string('lokasi')->nullable();
    $table->text('deskripsi')->nullable();
    $table->string('penyelenggara')->nullable();
    $table->string('status')->default('upcoming'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};

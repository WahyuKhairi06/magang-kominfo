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
        Schema::create('dasawismas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dasawisma')->unique();
            $table->integer('dusun_id');
            $table->integer('desa_id');
            $table->integer('kecamatan_id');
            $table->integer('pokja_id');
            $table->year('tahun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dasawismas');
    }
};

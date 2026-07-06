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
        Schema::create('dasawisma2026s', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('dasawisma_id');
            $table->year('tahun');

            // KOLOM SESUAI GAMBAR
            $table->unsignedInteger('tbc')->default(0);
            $table->unsignedInteger('jamban_sehat')->default(0);
            $table->unsignedInteger('bak_penampungan_air')->default(0);
            $table->unsignedInteger('penyakit_diare')->default(0);
            $table->unsignedInteger('keluarga_sadar_gizi')->default(0);
            $table->unsignedInteger('rumah_tanpa_asap_rokok')->default(0);
            $table->unsignedInteger('bab_sembarangan')->default(0);

            $table->unsignedInteger('b3_dapat_mbg')->default(0);     // kolom kuning
            $table->unsignedInteger('sampah_terpilah')->default(0);  // kolom kuning

            $table->unsignedInteger('spal')->default(0);
            $table->unsignedInteger('persalinan_ditolong_difaskes')->default(0);
            $table->unsignedInteger('asi_ekslusif')->default(0);
            $table->unsignedInteger('timbang_balita')->default(0);
            $table->unsignedInteger('berantas_jentik')->default(0);
            $table->unsignedInteger('makan_buah_sayur')->default(0);
            $table->unsignedInteger('balita_stunting')->default(0);
            $table->unsignedInteger('kb_aktif')->default(0);
            $table->unsignedInteger('penghasilan_tetap')->default(0);

            $table->text('ket')->nullable();


   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dasawisma2026s');
    }
};

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
        Schema::create('dasawisma2025s', function (Blueprint $table) {
            $table->id();
             $table->integer('dasawisma_id')->default(0);
             $table->unsignedInteger('protokol_kesehatan')->default(0);
            $table->unsignedInteger('jamban_sehat')->default(0);
            $table->unsignedInteger('bak_penampungan_air')->default(0);
            $table->unsignedInteger('penurunan_penyakit_diare')->default(0);
            $table->unsignedInteger('keluarga_sadar_gizi')->default(0);
            $table->unsignedInteger('rumah_tanpa_asap_rokok')->default(0);
            $table->unsignedInteger('bab_sembarangan')->default(0);
            $table->unsignedInteger('memiliki_bak_sampah')->default(0);
            $table->unsignedInteger('spal')->default(0);

            // IBU & ANAK
            $table->unsignedInteger('persalinan_di_faskes')->default(0);
            $table->unsignedInteger('asi_ekslusif')->default(0);
            $table->unsignedInteger('timbang_balita')->default(0);
            $table->unsignedInteger('berantas_jentik')->default(0);

            // POLA HIDUP
            $table->unsignedInteger('makan_buah_dan_sayur')->default(0);
            $table->unsignedInteger('aktivitas_fisik')->default(0);

            // STATUS ANAK & KB
            $table->unsignedInteger('balita_stunting')->default(0);
            $table->unsignedInteger('kb')->default(0);

            // EKONOMI
            $table->unsignedInteger('berpenghasilan_tetap')->default(0);

            $table->text('ket')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dasawisma2025s');
    }
};

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
        Schema::create('dokumens', function (Blueprint $table) {
            $table->id();
            Schema::create('dokumen', function (Blueprint $table) {
    $table->id();
    $table->string('judul'); // nama dokumen
    $table->string('file'); // path file (pdf/doc)
    $table->string('kategori')->nullable(); // contoh: Surat, Laporan
    $table->text('deskripsi')->nullable();
    $table->integer('jumlah_download')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumens');
    }
};

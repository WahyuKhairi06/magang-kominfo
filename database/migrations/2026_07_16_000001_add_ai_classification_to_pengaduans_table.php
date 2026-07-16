<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            // Hasil mentah dari AI — TIDAK BERUBAH walau admin override (jejak audit)
            $table->string('kategori_ai', 100)->nullable()->after('isi_pengaduan');
            $table->enum('urgensi_ai', ['rendah', 'sedang', 'tinggi'])->nullable()->after('kategori_ai');
            $table->text('alasan_ai')->nullable()->after('urgensi_ai');

            // Nilai AKTIF yang ditampilkan sebagai chip hijau — awalnya = hasil AI,
            // berubah kalau admin override
            $table->string('kategori_final', 100)->nullable()->after('alasan_ai');
            $table->enum('urgensi_final', ['rendah', 'sedang', 'tinggi'])->nullable()->after('kategori_final');

            $table->boolean('is_overridden')->default(false)->after('urgensi_final');
            $table->enum('status_klasifikasi', ['pending', 'selesai', 'gagal'])
                ->default('pending')
                ->after('is_overridden');

            $table->unsignedBigInteger('reviewed_by')->nullable()->after('status_klasifikasi');
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');

            $table->index('status_klasifikasi');
            $table->index('urgensi_final');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn([
                'kategori_ai',
                'urgensi_ai',
                'alasan_ai',
                'kategori_final',
                'urgensi_final',
                'is_overridden',
                'status_klasifikasi',
                'reviewed_by',
                'reviewed_at',
            ]);
        });
    }
};

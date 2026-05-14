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
        Schema::create('peminjamen', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->timestamp('tgl_reservasi'); // Waktu klik di web
    $table->timestamp('batas_ambil');    // tgl_reservasi + 2 jam
    $table->timestamp('tgl_pinjam')->nullable(); // Diisi saat ambil buku offline
    $table->date('tgl_kembali_plan')->nullable(); // Deadline kembali
    $table->string('jaminan')->nullable(); // Contoh: KTP
    $table->enum('status', ['reservasi', 'dipinjam', 'batal', 'selesai'])->default('reservasi');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};

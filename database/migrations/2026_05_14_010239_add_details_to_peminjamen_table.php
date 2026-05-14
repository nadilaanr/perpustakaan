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
    Schema::table('peminjamen', function (Blueprint $table) {
        // Hanya tambahkan kolom yang belum ada
        if (!Schema::hasColumn('peminjamen', 'status')) {
            $table->enum('status', ['dipinjam', 'dikembalikan', 'terlambat'])->default('dipinjam');
        }
        if (!Schema::hasColumn('peminjamen', 'denda')) {
            $table->integer('denda')->default(0);
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamen', function (Blueprint $table) {
            //
        });
    }
};

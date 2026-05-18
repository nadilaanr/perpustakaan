<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    protected $table = 'peminjamen';

    // FIX: Membuka gembok akses agar kolom tgl_reservasi dan batas_ambil bisa diisi oleh Laravel
    protected $fillable = [
        'user_id', 
        'buku_id', 
        'tgl_reservasi',  // <--- WAJIB ADA
        'batas_ambil',    // <--- WAJIB ADA
        'tgl_pinjam', 
        'tgl_kembali_plan', 
        'status', 
        'denda'
    ];

    // FIX: Daftarkan semua kolom waktu agar dikenali sebagai objek Carbon secara seragam
    protected $casts = [
        'tgl_reservasi' => 'datetime',
        'batas_ambil' => 'datetime',
        'tgl_pinjam' => 'datetime',
        'tgl_kembali_plan' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    protected $table = 'peminjamen';

    protected $fillable = [
        'user_id', 
        'buku_id', 
        'tgl_pinjam', 
        'tgl_kembali_plan', 
        'status', 
        'denda'
    ];

    // TAMBAHKAN INI: Agar Laravel tahu ini adalah tanggal
    protected $casts = [
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
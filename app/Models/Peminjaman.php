<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    // Jika nama tabelmu di database 'peminjamen', tambahkan ini untuk keamanan
    protected $table = 'peminjamen';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'user_id', 
        'buku_id', 
        'tanggal_pinjam', 
        'tanggal_kembali', 
        'status', 
        'denda'
    ];

    /**
     * Relasi ke model User (Siapa yang meminjam)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model Buku (Buku apa yang dipinjam)
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku; 

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buku IT / Coding
        Buku::create([
            'judul' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
            'penulis' => 'Robert C. Martin',
            'penerbit' => 'Prentice Hall',
            'tahun_terbit' => 2008,
            'stok' => 5,
            'gambar' => 'clean.jpeg'
        ]);

        Buku::create([
            'judul' => 'The Pragmatic Programmer',
            'penulis' => 'Andrew Hunt & David Thomas',
            'penerbit' => 'Addison-Wesley',
            'tahun_terbit' => 1999,
            'stok' => 3,
            'gambar' => 'pragmatic.jpeg'
        ]);

        Buku::create([
            'judul' => 'Eloquent JavaScript',
            'penulis' => 'Marijn Haverbeke',
            'penerbit' => 'No Starch Press',
            'tahun_terbit' => 2018,
            'stok' => 4,
            'gambar' => 'eloquent.jpeg'
        ]);

        // 2. Buku Literatur Indonesia 
        Buku::create([
            'judul' => 'Laskar Pelangi',
            'penulis' => 'Andrea Hirata',
            'penerbit' => 'Bentang Pustaka',
            'tahun_terbit' => 2005,
            'stok' => 10,
            'gambar' => 'laskar.jpeg'
        ]);

        Buku::create([
            'judul' => 'Bumi Manusia',
            'penulis' => 'Pramoedya Ananta Toer',
            'penerbit' => 'Hasta Mitra',
            'tahun_terbit' => 1980,
            'stok' => 2,
            'gambar' => 'bumi.jpeg'
        ]);

        Buku::create([
            'judul' => 'Filosofi Teras',
            'penulis' => 'Henry Manampiring',
            'penerbit' => 'Kompas',
            'tahun_terbit' => 2018,
            'stok' => 7,
            'gambar' => 'filosofi.jpeg'
        ]);

        // 3. Buku Pengembangan Diri / Bisnis
        Buku::create([
            'judul' => 'Atomic Habits',
            'penulis' => 'James Clear',
            'penerbit' => 'Penguin Random House',
            'tahun_terbit' => 2018,
            'stok' => 12,
            'gambar' => 'atomic.jpeg'
        ]);

        Buku::create([
            'judul' => 'Rich Dad Poor Dad',
            'penulis' => 'Robert Kiyosaki',
            'penerbit' => 'Warner Books',
            'tahun_terbit' => 1997,
            'stok' => 5,
            'gambar' => 'rich.jpeg'
        ]);

        Buku::create([
            'judul' => 'The Psychology of Money',
            'penulis' => 'Morgan Housel',
            'penerbit' => 'Harriman House',
            'tahun_terbit' => 2020,
            'stok' => 6,
            'gambar' => 'money.jpeg'
        ]);

        Buku::create([
            'judul' => 'Start with Why',
            'penulis' => 'Simon Sinek',
            'penerbit' => 'Portfolio',
            'tahun_terbit' => 2009,
            'stok' => 4,
            'gambar' => 'start.jpeg'
        ]);
    }
}

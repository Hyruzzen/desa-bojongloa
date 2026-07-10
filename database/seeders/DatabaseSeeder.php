<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@desabojongloa.go.id'],
            [
                'name' => 'Admin Desa Bojongloa',
                'password' => Hash::make('bojongloa123'),
            ]
        );

        $kategoris = [
            ['nama' => 'Surat Keputusan', 'deskripsi' => 'Arsip SK Kepala Desa'],
            ['nama' => 'Surat Masuk', 'deskripsi' => 'Arsip surat masuk kantor desa'],
            ['nama' => 'Surat Keluar', 'deskripsi' => 'Arsip surat keluar kantor desa'],
            ['nama' => 'Laporan Keuangan', 'deskripsi' => 'Arsip laporan keuangan desa'],
            ['nama' => 'Dokumen Kependudukan', 'deskripsi' => 'Arsip terkait data kependudukan'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::firstOrCreate(['nama' => $kategori['nama']], $kategori);
        }
    }
}

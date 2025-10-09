<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sertifikat;
use Illuminate\Support\Str;

class SertifikatSeeder extends Seeder
{
    public function run(): void
    {
        $namaDepan = ['Budi', 'Ahmad', 'Siti', 'Dewi', 'Rudi', 'Ani', 'Eko', 'Sri', 'Joko', 'Rina'];
        $namaBelakang = ['Santoso', 'Wijaya', 'Pratama', 'Kusuma', 'Setiawan', 'Permata', 'Utomo', 'Lestari', 'Saputra', 'Wati'];
        
        $judulDokumen = [
            'Sertifikat Hak Milik Tanah',
            'Sertifikat Rumah Tinggal',
            'Sertifikat Tanah Kavling',
            'Sertifikat Properti Komersial',
            'Sertifikat Hak Guna Bangunan',
            'Sertifikat Tanah Pertanian',
            'Sertifikat Apartemen',
            'Sertifikat Ruko',
            'Sertifikat Tanah Kosong',
            'Sertifikat Bangunan Kantor'
        ];

        for ($i = 1; $i <= 100; $i++) {
            $tahun = rand(2020, 2025);
            $bulan = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
            $nomor = str_pad($i, 4, '0', STR_PAD_LEFT);
            
            Sertifikat::create([
                'uuid' => (string) Str::uuid(),
                'nomor_sertifikat' => "SRT-{$nomor}/{$tahun}",
                'nama_pemilik' => $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)],
                'tanggal_terbit' => "{$tahun}-{$bulan}-" . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                'judul_dokumen' => $judulDokumen[array_rand($judulDokumen)],
                'file_sertifikat' => null,
                'file_warkah' => null,
                'foto_ttd' => null,
            ]);
        }
    }
}
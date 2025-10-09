<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Legnot;
use Illuminate\Support\Str;

class LegnotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $namaKlien = [
            'PT Maju Jaya Sentosa',
            'CV Berkah Abadi',
            'Budi Santoso',
            'Siti Nurhaliza',
            'Ahmad Dahlan',
            'Dewi Lestari',
            'Rudi Hartono',
            'Maya Sari',
            'Agus Wijaya',
            'Rina Kusuma',
            'PT Sukses Makmur',
            'CV Cahaya Terang',
            'Bambang Supriadi',
            'Linda Kartika',
            'Hendra Gunawan',
            'Fitri Handayani',
            'Joko Widodo',
            'Ani Yudhoyono',
            'Rizki Pratama',
            'Dian Sastro',
            'PT Global Utama',
            'CV Mandiri Sejahtera',
            'Andi Firmansyah',
            'Nurul Hidayah',
            'Fajar Ramadhan',
            'Indah Permata',
            'Wahyu Setiawan',
            'Ratna Sari Dewi',
            'Eko Prabowo',
            'Sinta Wijayanti',
            'PT Karya Persada',
            'CV Bintang Cemerlang',
            'Dedi Kusnandar',
            'Yuni Shara',
            'Irwan Maulana',
            'Putri Ayu',
            'Tono Suratno',
            'Lilis Suryani',
            'Hadi Pranoto',
            'Erna Kusumawati'
        ];

        $judulDokumen = [
            'Legalisasi Akta Pendirian Perusahaan',
            'Legalisasi Surat Kuasa',
            'Legalisasi Akta Jual Beli',
            'Legalisasi Perjanjian Kerjasama',
            'Legalisasi Surat Pernyataan',
            'Legalisasi Akta Hibah',
            'Legalisasi Akta Perubahan Anggaran Dasar',
            'Legalisasi Surat Keterangan',
            'Legalisasi Akta Pengakuan Hutang',
            'Legalisasi Perjanjian Sewa Menyewa',
            'Legalisasi Akta Pemberian Hak Tanggungan',
            'Legalisasi Surat Perjanjian Kredit',
            'Legalisasi Akta Fidusia',
            'Legalisasi Berita Acara Rapat',
            'Legalisasi Surat Persetujuan',
            'Legalisasi Akta Kuasa Menjual',
            'Legalisasi Perjanjian Pengikatan Jual Beli',
            'Legalisasi Surat Pernyataan Kesanggupan',
            'Legalisasi Akta Pendirian Yayasan',
            'Legalisasi Surat Keterangan Ahli Waris'
        ];

        // Generate 100 data
        for ($i = 1; $i <= 100; $i++) {
            Legnot::create([
                'uuid' => (string) Str::uuid(),
                'nomor_legalisasi' => sprintf('%03d/LEG/%s/%d', $i, 'X', 2025),
                'judul' => $judulDokumen[array_rand($judulDokumen)],
                'nama_klien' => $namaKlien[array_rand($namaKlien)],
                'tanggal' => now()->subDays(rand(1, 365))->format('Y-m-d'),
                'file_legnot' => null // Kosongkan dulu untuk dummy data
            ]);
        }

        $this->command->info('✅ Berhasil membuat 100 data dummy Legnot!');
    }
}
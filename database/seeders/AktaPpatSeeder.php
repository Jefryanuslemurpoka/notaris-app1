<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AktaPpat;
use Illuminate\Support\Str;

class AktaPpatSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) {
            AktaPpat::create([
                'uuid' => Str::uuid()->toString(),
                'judul_akta' => 'Judul Akta PPAT ' . $i,
                'nomor_akta' => 'PPAT-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'tanggal_akta' => now()->subDays(rand(0, 365)),
                'pihak_1' => 'Pihak 1 - ' . $i,
                'pihak_2' => 'Pihak 2 - ' . $i,
                'saksi_1' => 'Saksi 1 - ' . $i,
                'saksi_2' => 'Saksi 2 - ' . $i,
                'file_akta' => 'akta_ppat/dummy_' . $i . '.pdf', // ✅ kasih dummy path
                'foto_ttd_para_pihak' => null,
                'warkah' => null,
            ]);
        }
    }
}
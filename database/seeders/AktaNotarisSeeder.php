<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AktaNotaris;
use Illuminate\Support\Str;

class AktaNotarisSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) {
            AktaNotaris::create([
                'judul' => 'Judul Akta ' . $i,
                'nomor_akta' => 'NO-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'tanggal_akta' => now()->subDays(rand(0, 365)),
                'penghadap' => ['Penghadap A'.$i, 'Penghadap B'.$i],
                'saksi1' => 'Saksi1 '.$i,
                'saksi2' => 'Saksi2 '.$i,
                'file_akta' => null,
                'foto_ttd' => null,
                'file_sk' => null,
                'file_warkah' => null,
                'uuid' => Str::uuid()->toString(),
            ]);
        }
    }
}

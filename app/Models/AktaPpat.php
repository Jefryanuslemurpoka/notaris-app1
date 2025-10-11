<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AktaPpat extends Model
{
    protected $table = 'akta_ppat';

    protected $fillable = [
        'uuid',
        'judul_akta',
        'nomor_akta',
        'tanggal_akta',
        'pihak_1',
        'pihak_2',
        'saksi_1',
        'saksi_2',
        'file_akta',
        'foto_ttd_para_pihak',
        'warkah',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_akta' => 'date'
    ];

    // PENTING: Auto generate UUID saat create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    // Gunakan UUID untuk route model binding
    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
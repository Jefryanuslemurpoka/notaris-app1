<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AktaNotaris extends Model
{
    protected $fillable = [
        'uuid',
        'judul',
        'nomor_akta',
        'tanggal_akta',
        'penghadap',
        'saksi1',
        'saksi2',
        'file_akta',
        'foto_ttd',
        'file_sk',
        'file_warkah',
        'status',
        'catatan'
    ];

    protected $casts = [
        'penghadap' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }
        });
    }
}
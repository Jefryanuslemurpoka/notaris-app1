<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sertifikat extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'nomor_sertifikat',
        'nama_pemilik',
        'tanggal_terbit',
        'judul_dokumen',
        'file_sertifikat',
        'file_warkah',
        'foto_ttd',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}
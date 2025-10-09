<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sertifikats', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('nomor_sertifikat')->unique();
            $table->string('nama_pemilik');
            $table->date('tanggal_terbit');
            $table->string('judul_dokumen');
            $table->string('file_sertifikat')->nullable();
            $table->string('file_warkah')->nullable();
            $table->string('foto_ttd')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikats');
    }
};
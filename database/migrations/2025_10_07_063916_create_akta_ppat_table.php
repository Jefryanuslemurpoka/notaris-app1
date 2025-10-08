<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akta_ppat', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();  // ← TAMBAHKAN INI
            $table->string('judul_akta');
            $table->string('nomor_akta');
            $table->date('tanggal_akta');
            $table->string('pihak_1');
            $table->string('pihak_2');
            $table->string('saksi_1')->nullable();
            $table->string('saksi_2')->nullable();
            $table->string('file_akta');
            $table->string('foto_ttd_para_pihak')->nullable();
            $table->string('warkah')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akta_ppat');
    }
};
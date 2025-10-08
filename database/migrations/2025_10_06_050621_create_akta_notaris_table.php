<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('akta_notaris', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('judul');
            $table->string('nomor_akta')->nullable();
            $table->date('tanggal_akta')->nullable();
            $table->json('penghadap')->nullable(); // bisa menampung banyak penghadap
            $table->string('saksi1')->nullable();
            $table->string('saksi2')->nullable();
            $table->string('file_akta')->nullable();
            $table->string('foto_ttd')->nullable();
            $table->string('file_sk')->nullable();
            $table->string('file_warkah')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('akta_notaris');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Support;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->enum('status', ['pending', 'selesai'])->default('pending')->after('foto_ttd');
            $table->text('catatan')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('sertifikats', function (Blueprint $table) {
            $table->dropColumn(['status', 'catatan']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('akta_ppat', function (Blueprint $table) {
            // Cek apakah kolom 'catatan' sudah ada
            if (!Schema::hasColumn('akta_ppat', 'catatan')) {
                $table->text('catatan')->nullable()->after('status');
            }
        });
    }

    public function down()
    {
        Schema::table('akta_ppat', function (Blueprint $table) {
            // Drop hanya jika kolom ada
            if (Schema::hasColumn('akta_ppat', 'catatan')) {
                $table->dropColumn('catatan');
            }
        });
    }
};
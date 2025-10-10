<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('akta_notaris', function (Blueprint $table) {
            $table->enum('status', ['selesai', 'pending'])->default('pending')->after('file_warkah');
            $table->text('catatan')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('akta_notaris', function (Blueprint $table) {
            $table->dropColumn(['status', 'catatan']);
        });
    }
};
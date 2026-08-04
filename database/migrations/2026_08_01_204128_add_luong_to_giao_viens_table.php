<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('giao_viens', function (Blueprint $table) {
            $table->unsignedInteger('luong_co_ban')->nullable()->after('chuc_danh');
            $table->unsignedInteger('don_gia_gio')->nullable()->after('luong_co_ban');
        });
    }

    public function down(): void
    {
        Schema::table('giao_viens', function (Blueprint $table) {
            $table->dropColumn(['luong_co_ban', 'don_gia_gio']);
        });
    }
};
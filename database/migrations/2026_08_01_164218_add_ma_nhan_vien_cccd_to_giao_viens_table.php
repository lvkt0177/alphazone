<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('giao_viens', function (Blueprint $table) {
            $table->string('ma_nhan_vien', 50)->nullable()->unique()->after('ho_ten');
            $table->string('cccd', 12)->nullable()->unique()->after('ma_nhan_vien');
        });
    }

    public function down(): void
    {
        Schema::table('giao_viens', function (Blueprint $table) {
            $table->dropColumn(['ma_nhan_vien', 'cccd']);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('phieu_luong_nhan_viens', function (Blueprint $table) {
            $table->boolean('ap_dung_bhxh')->default(true)->after('bhxh');
            $table->boolean('ap_dung_bhyt')->default(true)->after('bhyt');
            $table->boolean('ap_dung_bhtn')->default(true)->after('bhtn');
        });
    }

    public function down(): void
    {
        Schema::table('phieu_luong_nhan_viens', function (Blueprint $table) {
            $table->dropColumn(['ap_dung_bhxh', 'ap_dung_bhyt', 'ap_dung_bhtn']);
        });
    }
};
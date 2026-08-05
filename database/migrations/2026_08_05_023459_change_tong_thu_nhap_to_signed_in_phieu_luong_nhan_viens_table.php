<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('phieu_luong_nhan_viens', function (Blueprint $table) {
            $table->decimal('tong_thu_nhap', 15, 2)->change();
            $table->decimal('thu_nhap_chiu_thue', 15, 2)->change();
            $table->decimal('luong_thuc_nhan', 15, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('phieu_luong_nhan_viens', function (Blueprint $table) {
            $table->decimal('tong_thu_nhap', 15, 2)->unsigned()->change();
            $table->decimal('thu_nhap_chiu_thue', 15, 2)->unsigned()->change();
            $table->decimal('luong_thuc_nhan', 15, 2)->unsigned()->change();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cham_cong_giao_viens', function (Blueprint $table) {
            $table->unsignedInteger('ho_tro_dung_lop')->nullable()->after('ho_tro_xang_xe');
        });
    }

    public function down(): void
    {
        Schema::table('cham_cong_giao_viens', function (Blueprint $table) {
            $table->dropColumn('ho_tro_dung_lop');
        });
    }
};

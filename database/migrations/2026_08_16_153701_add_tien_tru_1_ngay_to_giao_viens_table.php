<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('giao_viens', function (Blueprint $table) {
            $table->unsignedInteger('tien_tru_1_ngay')->nullable()->after('luong_co_ban');
        });
    }

    public function down(): void
    {
        Schema::table('giao_viens', function (Blueprint $table) {
            $table->dropColumn('tien_tru_1_ngay');
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('phieu_luong_ctvs', function (Blueprint $table) {
            $table->unsignedInteger('tro_cap')->nullable()->after('don_gia');
        });
    }

    public function down(): void
    {
        Schema::table('phieu_luong_ctvs', function (Blueprint $table) {
            $table->dropColumn('tro_cap');
        });
    }
};
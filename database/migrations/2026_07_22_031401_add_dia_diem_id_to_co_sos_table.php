<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('co_sos', function (Blueprint $table) {
            $table->foreignId('dia_diem_id')->nullable()->after('giao_vien_id')
                ->constrained('dia_diems')->restrictOnDelete(); // còn Cơ sở thuộc về thì không cho xoá Địa điểm
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('co_sos', function (Blueprint $table) {
            $table->dropForeign(['dia_diem_id']);
            $table->dropColumn('dia_diem_id');
        });
    }
};

<?php

use App\Enum\ChucDanhGiaoVien;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('giao_viens', function (Blueprint $table) {
            $table->tinyInteger('chuc_danh')
                ->default(ChucDanhGiaoVien::THAY_PHU_TRACH->value)
                ->after('sdt');
        });
    }

    public function down(): void
    {
        Schema::table('giao_viens', function (Blueprint $table) {
            $table->dropColumn('chuc_danh');
        });
    }
};
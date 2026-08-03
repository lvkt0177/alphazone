<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cai_dat_luong_thays', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ngay_cong_toi_thieu')->default(19);
            $table->unsignedInteger('tien_tru_1_ngay')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cai_dat_luong_thays');
    }
};
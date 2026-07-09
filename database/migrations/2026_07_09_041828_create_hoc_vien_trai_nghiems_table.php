<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hoc_vien_trai_nghiems', function (Blueprint $table) {
            $table->id();
            $table->string('ho_ten');
            $table->unsignedSmallInteger('nam_sinh')->nullable();
            $table->unsignedTinyInteger('trang_thai')->default(3); // 3 = Chưa trải nghiệm
            $table->text('ghi_chu')->nullable();
            $table->timestamps();
        });

        Schema::create('hoc_vien_trai_nghiem_co_so', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoc_vien_trai_nghiem_id')->constrained('hoc_vien_trai_nghiems')->cascadeOnDelete();
            $table->foreignId('co_so_id')->constrained('co_sos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hoc_vien_trai_nghiem_co_so');
        Schema::dropIfExists('hoc_vien_trai_nghiems');
    }
};

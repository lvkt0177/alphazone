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
        Schema::create('hoc_viens', function (Blueprint $table) {
            $table->id();
            $table->string('ma_so')->unique();
            $table->string('ho_ten');
            $table->string('nickname')->nullable();
            $table->date('ngay_sinh')->nullable();
            $table->unsignedTinyInteger('gioi_tinh')->default(1); // 1 = Nam
            $table->string('sdt', 15)->nullable();
            $table->string('truong')->nullable();
            $table->string('dia_chi')->nullable();
            $table->string('avatar')->nullable();
            $table->unsignedTinyInteger('trang_thai')->default(1); // 1 = Khách hàng
            $table->foreignId('tu_hoc_vien_trai_nghiem_id')->nullable()
                ->constrained('hoc_vien_trai_nghiems')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('hoc_vien_co_so', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoc_vien_id')->constrained('hoc_viens')->cascadeOnDelete();
            $table->foreignId('co_so_id')->constrained('co_sos')->restrictOnDelete(); // đúng case CO_SO: có học viên thì chặn xoá
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hoc_vien_co_so');
        Schema::dropIfExists('hoc_viens');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phieu_luong_ctvs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('giao_vien_id')->constrained('giao_viens')->cascadeOnDelete();
            $table->date('thang');

            $table->string('ho_ten_snapshot');
            $table->string('ma_nhan_vien_snapshot')->nullable();
            $table->decimal('tong_so_gio', 6, 1)->default(0);
            $table->unsignedInteger('don_gia');

            $table->unsignedInteger('thanh_tien')->default(0); 
            $table->unsignedInteger('khau_tru')->nullable();
            $table->integer('thuc_nhan')->default(0);

            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['giao_vien_id', 'thang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phieu_luong_ctvs');
    }
};
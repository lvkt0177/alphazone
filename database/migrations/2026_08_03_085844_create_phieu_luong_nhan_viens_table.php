<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phieu_luong_nhan_viens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('giao_vien_id')->constrained('giao_viens')->cascadeOnDelete();
            $table->date('thang');
            $table->date('ngay_chot')->nullable();

            $table->string('ho_ten_snapshot');
            $table->string('ma_nhan_vien_snapshot')->nullable();
            $table->unsignedInteger('luong_co_ban');

            $table->unsignedInteger('ngay_cong_chuan')->nullable();
            $table->unsignedInteger('so_ngay_co_luong')->default(0);
            $table->unsignedInteger('so_ngay_khong_luong')->default(0);

            $table->unsignedInteger('tro_cap')->nullable();
            $table->unsignedInteger('nang_suat')->nullable();
            $table->unsignedInteger('thuong_khac')->nullable();

            $table->integer('tong_thu_nhap')->default(0);
            $table->unsignedInteger('tong_khau_tru')->default(0);
            $table->unsignedInteger('cong_tac_phi')->nullable();
            $table->unsignedInteger('tam_ung')->nullable();
            $table->unsignedInteger('giam_tru_gia_canh')->nullable();

            $table->unsignedInteger('bhxh')->default(0);
            $table->unsignedInteger('bhyt')->default(0);
            $table->unsignedInteger('bhtn')->default(0);

            $table->integer('thu_nhap_chiu_thue')->default(0);
            $table->integer('tntt')->default(0);
            $table->unsignedInteger('thue_tncn')->default(0);
            $table->integer('luong_thuc_nhan')->default(0);

            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['giao_vien_id', 'thang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phieu_luong_nhan_viens');
    }
};
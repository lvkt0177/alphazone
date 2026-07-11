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
        Schema::create('diem_danhs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoc_vien_id')->constrained('hoc_viens')->restrictOnDelete();
            $table->foreignId('co_so_id')->constrained('co_sos')->restrictOnDelete();
            $table->foreignId('giao_vien_id')->nullable()->constrained('giao_viens')->nullOnDelete();
            $table->date('ngay');
            $table->unsignedTinyInteger('trang_thai');
            $table->string('ghi_chu')->nullable();
            $table->timestamps();

            $table->unique(['hoc_vien_id', 'co_so_id', 'ngay']); // 1 học viên chỉ có 1 bản ghi điểm danh / ngày / cơ sở
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diem_danhs');
    }
};

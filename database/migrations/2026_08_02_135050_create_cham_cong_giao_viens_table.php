<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cham_cong_giao_viens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('giao_vien_id')->constrained('giao_viens')->cascadeOnDelete();
            $table->date('ngay');
            $table->boolean('co_di_lam')->nullable();
            $table->decimal('so_gio', 4, 1)->nullable();
            $table->unsignedInteger('ho_tro_xang_xe')->nullable();
            $table->string('ghi_chu')->nullable();
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['giao_vien_id', 'ngay']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cham_cong_giao_viens');
    }
};
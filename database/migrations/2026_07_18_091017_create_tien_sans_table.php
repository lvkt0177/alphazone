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
        Schema::create('tien_sans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('co_so_id')->constrained('co_sos')->restrictOnDelete(); // có lịch sử tài chính thì không cho xoá cứng Cơ sở, khớp rule G3
            $table->date('ngay');
            $table->unsignedInteger('so_tien');
            $table->string('ghi_chu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tien_sans');
    }
};

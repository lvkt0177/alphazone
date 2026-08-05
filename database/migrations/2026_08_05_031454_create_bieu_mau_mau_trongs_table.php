<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bieu_mau_mau_trongs', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('loai')->unique();
            $table->string('file_path');
            $table->string('file_name_goc');
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bieu_mau_mau_trongs');
    }
};
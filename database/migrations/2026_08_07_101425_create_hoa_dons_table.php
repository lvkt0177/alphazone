<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hoa_dons', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('loai');
            $table->string('ten');
            $table->string('file_path');
            $table->string('file_name_goc');
            $table->timestamps();

            $table->index('loai');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hoa_dons');
    }
};
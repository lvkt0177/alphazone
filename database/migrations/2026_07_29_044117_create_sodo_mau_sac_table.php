<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sodo_mau_sac', function (Blueprint $table) {
            $table->id();
            $table->json('mau_sac');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sodo_mau_sac');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('chuc_nang_id')->constrained('chuc_nangs')->cascadeOnDelete();
            $table->boolean('xem')->default(false);
            $table->boolean('them')->default(false);
            $table->boolean('sua')->default(false);
            $table->boolean('xoa')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'chuc_nang_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_permissions');
    }
};

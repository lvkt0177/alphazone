<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('giao_ans', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('cap_hoc');
            $table->tinyInteger('loai_game');
            $table->tinyInteger('chu_de')->nullable();
            $table->string('ten_tro_choi');
            $table->text('cach_choi')->nullable();
            $table->text('luat_choi')->nullable();
            $table->json('so_do')->nullable();
            $table->string('video_path')->nullable();
            $table->timestamps();

            $table->index(['cap_hoc', 'loai_game', 'chu_de']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('giao_ans');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cai_dat_hoc_phis', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('so_luong_co_so')->unique();
            $table->unsignedInteger('hoc_phi');
            $table->unsignedTinyInteger('tong_so_buoi');
            $table->timestamps();
        });

        DB::table('cai_dat_hoc_phis')->insert([
            ['so_luong_co_so' => 1, 'hoc_phi' => 500000, 'tong_so_buoi' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['so_luong_co_so' => 2, 'hoc_phi' => 800000, 'tong_so_buoi' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['so_luong_co_so' => 3, 'hoc_phi' => 1100000, 'tong_so_buoi' => 12, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cai_dat_hoc_phis');
    }
};
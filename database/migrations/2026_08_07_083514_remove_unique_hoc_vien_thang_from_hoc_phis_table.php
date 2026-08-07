<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hoc_phis', function (Blueprint $table) {
            $table->index(['hoc_vien_id', 'thang']);
        });

        Schema::table('hoc_phis', function (Blueprint $table) {
            $table->dropUnique(['hoc_vien_id', 'thang']);
        });
    }

    public function down(): void
    {
        Schema::table('hoc_phis', function (Blueprint $table) {
            $table->unique(['hoc_vien_id', 'thang']);
        });

        Schema::table('hoc_phis', function (Blueprint $table) {
            $table->dropIndex(['hoc_vien_id', 'thang']);
        });
    }
};
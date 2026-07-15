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
        Schema::table('hoc_phis', function (Blueprint $table) {
            $table->boolean('gioi_thieu_ban')->default(false)->after('hoc_vien_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoc_phis', fn (Blueprint $t) => $t->dropColumn('gioi_thieu_ban'));
    }
};

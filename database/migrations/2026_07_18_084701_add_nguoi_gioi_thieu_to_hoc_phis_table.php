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
            $table->foreignId('nguoi_gioi_thieu_id')->nullable()->after('gioi_thieu_ban')
                ->constrained('hoc_viens')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoc_phis', function (Blueprint $table) {
            $table->dropForeign(['nguoi_gioi_thieu_id']);
            $table->dropColumn('nguoi_gioi_thieu_id');
        });
    }
};

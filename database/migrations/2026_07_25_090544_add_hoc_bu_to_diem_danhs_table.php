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
        Schema::table('diem_danhs', function (Blueprint $table) {
            $table->boolean('hoc_bu')->default(false)->after('co_so_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diem_danhs', function (Blueprint $table) {
            $table->dropColumn('hoc_bu');
        });
    }
};

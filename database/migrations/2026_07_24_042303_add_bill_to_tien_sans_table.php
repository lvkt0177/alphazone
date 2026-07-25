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
        Schema::table('tien_sans', function (Blueprint $table) {
            $table->string('bill')->nullable()->after('ghi_chu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tien_sans', function (Blueprint $table) {
            $table->dropColumn('bill');
        });
    }
};

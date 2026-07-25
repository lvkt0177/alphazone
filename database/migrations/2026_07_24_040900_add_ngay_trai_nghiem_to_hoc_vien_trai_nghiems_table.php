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
        Schema::table('hoc_vien_trai_nghiems', function (Blueprint $table) {
            $table->date('ngay_trai_nghiem')->nullable()->after('nam_sinh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoc_vien_trai_nghiems', function (Blueprint $table) {
            $table->dropColumn('ngay_trai_nghiem');
        });
    }
};

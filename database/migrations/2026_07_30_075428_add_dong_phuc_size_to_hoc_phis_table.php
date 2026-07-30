<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hoc_phis', function (Blueprint $table) {
            $table->string('dong_phuc_size')->nullable()->after('dong_phuc');
        });
    }

    public function down(): void
    {
        Schema::table('hoc_phis', function (Blueprint $table) {
            $table->dropColumn('dong_phuc_size');
        });
    }
};

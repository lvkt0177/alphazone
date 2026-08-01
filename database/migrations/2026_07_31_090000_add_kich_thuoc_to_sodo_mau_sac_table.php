<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sodo_mau_sac', function (Blueprint $table) {
            if (!Schema::hasColumn('sodo_mau_sac', 'kich_thuoc')) {
                $table->json('kich_thuoc')->nullable()->after('mau_sac');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sodo_mau_sac', function (Blueprint $table) {
            if (Schema::hasColumn('sodo_mau_sac', 'kich_thuoc')) {
                $table->dropColumn('kich_thuoc');
            }
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hoa_dons', function (Blueprint $table) {
            $table->date('ngay_tao')->nullable()->after('ten');
        });

        \DB::table('hoa_dons')->whereNull('ngay_tao')->update([
            'ngay_tao' => \DB::raw('DATE(created_at)'),
        ]);
    }

    public function down(): void
    {
        Schema::table('hoa_dons', function (Blueprint $table) {
            $table->dropColumn('ngay_tao');
        });
    }
};
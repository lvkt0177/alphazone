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
        Schema::table('hoc_viens', function (Blueprint $table) {
            $table->text('ghi_chu')->nullable()->after('dia_chi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoc_viens', fn (Blueprint $t) => $t->dropColumn('ghi_chu'));
    }
};

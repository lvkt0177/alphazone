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
            $table->decimal('chieu_cao', 5, 1)->nullable()->after('gioi_tinh'); // cm, VD: 145.5
            $table->decimal('can_nang', 5, 1)->nullable()->after('chieu_cao');  // kg, VD: 38.2
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hoc_viens', function (Blueprint $table) {
            $table->dropColumn(['chieu_cao', 'can_nang']);
        });
    }
};

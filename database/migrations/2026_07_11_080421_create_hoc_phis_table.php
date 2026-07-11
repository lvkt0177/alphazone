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
        Schema::create('hoc_phis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoc_vien_id')->constrained('hoc_viens')->restrictOnDelete();
            $table->date('thang'); 
            $table->unsignedInteger('hoc_phi');
            $table->unsignedInteger('dong_phuc')->nullable();
            $table->date('ngay_dong');
            $table->timestamps();

            $table->unique(['hoc_vien_id', 'thang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hoc_phis');
    }
};

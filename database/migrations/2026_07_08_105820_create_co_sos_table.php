<?php

use App\Enum\TrangThaiCoSo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('co_sos', function (Blueprint $table) {
            $table->id();
            $table->string('ten');
            $table->foreignId('giao_vien_id')
                ->nullable()
                ->constrained('giao_viens')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->tinyInteger('trang_thai')->default(TrangThaiCoSo::ACTIVE->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('co_sos');
    }
};
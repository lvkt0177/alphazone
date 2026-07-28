<?php

use App\Enum\RoleUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('role')->default(RoleUser::ADMIN->value)->after('password');
            $table->foreignId('giao_vien_id')->nullable()->after('role')
                ->constrained('giao_viens')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('giao_vien_id');
            $table->dropColumn('role');
        });
    }
};

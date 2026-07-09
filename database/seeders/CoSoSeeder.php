<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\CoSo;
use App\Enum\TrangThaiCoSo;

class CoSoSeeder extends Seeder
{
    public function run(): void
    {
        CoSo::insert(
            [
                [
                    'ten' => 'Cơ sở 1',
                    'giao_vien_id' => 1,
                    'trang_thai' => TrangThaiCoSo::ACTIVE->value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'ten' => 'Cơ sở 2',
                    'giao_vien_id' => 2,
                    'trang_thai' => TrangThaiCoSo::ACTIVE->value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
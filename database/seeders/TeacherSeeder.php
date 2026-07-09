<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\GiaoVien;
use App\Enum\TrangThaiGiaoVien;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        GiaoVien::insert(
            [
                [
                    'ho_ten' => 'Nguyen Van A',
                    'ngay_sinh' => '1980-01-01',
                    'sdt' => '0123456789',
                    'trang_thai' => TrangThaiGiaoVien::DANG_DAY->value,
                ],
                [
                    'ho_ten' => 'Tran Thi B',
                    'ngay_sinh' => '1985-05-15',
                    'sdt' => '0987654321',
                    'trang_thai' => TrangThaiGiaoVien::DANG_DAY->value,
                ]
            ]
        );
    }
}
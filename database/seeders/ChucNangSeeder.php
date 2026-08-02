<?php

namespace Database\Seeders;

use App\Models\ChucNang;
use Illuminate\Database\Seeder;

class ChucNangSeeder extends Seeder
{
    public function run(): void
    {
        $danhSach = [
            ['key' => 'dashboard', 'ten' => 'Dashboard'],
            ['key' => 'coso', 'ten' => 'Cơ sở'],
            ['key' => 'giaovien', 'ten' => 'Giáo viên'],
            ['key' => 'hocvien', 'ten' => 'Học viên'],
            ['key' => 'diemdanh', 'ten' => 'Điểm danh'],
            ['key' => 'hocphi', 'ten' => 'Học phí'],
            ['key' => 'tiensan', 'ten' => 'Tiền sân'],
            ['key' => 'trainghiem', 'ten' => 'Trải nghiệm'],
            ['key' => 'caidathocphi', 'ten' => 'Cài đặt học phí'],
            ['key' => 'giaoan', 'ten' => 'Giáo án'],
            ['key' => 'bieumau', 'ten' => 'Biểu mẫu'],
            ['key' => 'caidattienluong', 'ten' => 'Cài đặt tiền lương'],
            ['key' => 'chamcong', 'ten' => 'Chấm công'],
        ];

        foreach ($danhSach as $item) {
            ChucNang::updateOrCreate(['key' => $item['key']], $item);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Enum\CapHocGiaoAn;
use App\Enum\ChuDeGiaoAn;
use App\Enum\LoaiGameGiaoAn;
use App\Models\GiaoAn;
use Illuminate\Database\Seeder;

class GiaoAnDemoSeeder extends Seeder
{
    /**
     * Số lượng giáo án sinh ra cho MỖI tổ hợp (Cấp học + Loại game [+ Chủ đề]).
     * Muốn nhiều/ít hơn thì đổi số này rồi chạy lại.
     */
    private int $soLuongMoiToHop = 10;

    private array $tuKhoaKyThuat = [
        'chuyền bóng ngắn', 'chuyền bóng dài', 'dẫn bóng zíc-zắc', 'sút bóng bằng mu bàn chân',
        'sút bóng bằng lòng trong', 'khống chế bóng bằng đùi', 'khống chế bóng bằng ngực',
        'di chuyển không bóng', 'tranh chấp tay đôi', 'phối hợp 2 chạm', 'phối hợp tam giác',
        'đá phạt góc', 'ném biên', 'phòng ngự khu vực', 'phòng ngự kèm người', 'phản công nhanh',
        'giữ nhịp trận đấu', 'chuyển trạng thái tấn công - phòng ngự', 'áp sát cướp bóng',
        'di chuyển hình chữ L', 'di chuyển hình tam giác', 'đảo hướng bất ngờ', 'giữ thăng bằng',
        'tăng tốc độ đột phá', 'phối hợp nhóm nhỏ', 'kiểm soát không gian thi đấu',
    ];

    private array $luuY = [
        'Giáo viên quan sát kỹ tư thế thân người của học viên khi thực hiện động tác',
        'Nhắc học viên giữ đầu gối hơi chùng để phản xạ nhanh hơn',
        'Ưu tiên chất lượng động tác hơn tốc độ ở những buổi đầu',
        'Chia nhóm theo trình độ để bài tập vừa sức với từng học viên',
        'Có thể tăng độ khó bằng cách thu hẹp không gian thi đấu',
        'Dừng lại chỉnh sửa ngay khi phát hiện sai kỹ thuật cơ bản',
        'Khuyến khích học viên giao tiếp, gọi tên đồng đội khi phối hợp',
        'Cho học viên nghỉ giữa hiệp nếu thấy dấu hiệu mệt mỏi quá sức',
        'Ghi nhận tiến bộ cá nhân để điều chỉnh giáo án buổi sau',
        'Luôn khởi động kỹ khớp cổ chân, đầu gối trước khi vào bài chính',
    ];

    public function run(): void
    {
        $tongSo = 0;

        foreach (CapHocGiaoAn::cases() as $capHoc) {
            foreach ($capHoc->danhSachLoaiGame() as $loaiGame) {
                if ($capHoc->coChuDe()) {
                    foreach (ChuDeGiaoAn::cases() as $chuDe) {
                        $tongSo += $this->taoNhieu($capHoc, $loaiGame, $chuDe);
                    }
                } else {
                    $tongSo += $this->taoNhieu($capHoc, $loaiGame, null);
                }
            }
        }

        $this->command?->info("Đã tạo {$tongSo} giáo án demo.");
    }

    private function taoNhieu(CapHocGiaoAn $capHoc, LoaiGameGiaoAn $loaiGame, ?ChuDeGiaoAn $chuDe): int
    {
        for ($i = 1; $i <= $this->soLuongMoiToHop; $i++) {
            GiaoAn::create([
                'cap_hoc' => $capHoc,
                'loai_game' => $loaiGame,
                'chu_de' => $chuDe,
                'ten_tro_choi' => $this->taoTen($capHoc, $loaiGame, $chuDe, $i),
                'cach_choi' => $this->taoDoanVanDai('Cách chơi', $i),
                'luat_choi' => $this->taoDoanVanDai('Luật chơi', $i),
                'so_do' => null,
                'video_path' => null,
            ]);
        }

        return $this->soLuongMoiToHop;
    }

    private function taoTen(CapHocGiaoAn $capHoc, LoaiGameGiaoAn $loaiGame, ?ChuDeGiaoAn $chuDe, int $i): string
    {
        $tuKhoa = ucfirst($this->tuKhoaKyThuat[array_rand($this->tuKhoaKyThuat)]);
        $phanChuDe = $chuDe ? ' - '.$chuDe->getLabel() : '';

        return "{$tuKhoa} #{$i} ({$capHoc->getLabel()} / {$loaiGame->getLabel()}{$phanChuDe})";
    }

    private function taoDoanVanDai(string $tieuDe, int $seed): string
    {
        $cauMoDau = "{$tieuDe} bài tập số {$seed}: ";
        $soCau = random_int(10, 16);
        $cacCau = [];

        for ($i = 0; $i < $soCau; $i++) {
            $tuKhoa1 = $this->tuKhoaKyThuat[array_rand($this->tuKhoaKyThuat)];
            $tuKhoa2 = $this->tuKhoaKyThuat[array_rand($this->tuKhoaKyThuat)];
            $soHocVien = random_int(4, 20);
            $soPhut = random_int(5, 25);

            $cacCau[] = "Chia {$soHocVien} học viên thành các nhóm nhỏ, luân phiên thực hiện {$tuKhoa1} kết hợp {$tuKhoa2} trong khoảng {$soPhut} phút, sau đó đổi vị trí cho nhóm còn lại tiếp tục luyện tập theo đúng trình tự đã hướng dẫn.";
        }

        $ghiChu = $this->luuY[array_rand($this->luuY)];

        return $cauMoDau.implode(' ', $cacCau).' Lưu ý: '.$ghiChu.'.';
    }
}
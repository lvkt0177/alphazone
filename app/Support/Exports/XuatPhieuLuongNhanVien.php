<?php

namespace App\Support\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class XuatPhieuLuongNhanVien
{
    public static function taoFile(Collection $phieus, Carbon $thang): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Thang '.$thang->format('m-Y'));

        $sheet->setCellValue('A1', 'BẢNG LƯƠNG THÁNG '.$thang->format('m/Y'));
        $sheet->mergeCells('A1:U1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $tieuDe = [
            'A' => 'STT', 'B' => 'Họ và tên', 'C' => 'Mã nhân viên', 'D' => 'Tổng cộng',
            'G' => "Lương cơ bản\n(VND)", 'H' => "Trợ cấp\n(VND)", 'I' => 'Năng suất công việc',
            'J' => "Thưởng khác\n(VND)", 'K' => 'Tổng Thu nhập', 'L' => 'BHXH (8%)', 'M' => 'BHYT (1,5%)',
            'N' => 'BHTN (1%)', 'O' => 'Tổng khấu trừ', 'P' => 'Công tác phí', 'Q' => 'Tạm ứng',
            'R' => 'Thu nhập chịu thuế', 'S' => 'Giảm trừ gia cảnh', 'T' => 'Thuế TNCN',
            'U' => "Lương thực nhận\n(VND)",
        ];
        foreach ($tieuDe as $col => $ten) {
            $sheet->setCellValue($col.'2', $ten);
        }
        $sheet->setCellValue('E2', 'Ngày nghỉ');
        $sheet->setCellValue('E3', "lương\n(P)");
        $sheet->setCellValue('F3', "không lương\n(k)");

        foreach (['A', 'B', 'C', 'D', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U'] as $col) {
            $sheet->mergeCells($col.'2:'.$col.'4');
        }
        $sheet->mergeCells('E2:F2');
        $sheet->mergeCells('E3:E4');
        $sheet->mergeCells('F3:F4');

        $sheet->getStyle('A2:U4')->getFont()->setBold(true);
        $sheet->getStyle('A2:U4')->getAlignment()->setWrapText(true)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A2:U4')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $row = 5;
        $stt = 1;
        foreach ($phieus as $p) {
            $tongCong = $p->ngay_cong_chuan ?? (($p->so_ngay_co_luong ?? 0) + ($p->so_ngay_khong_luong ?? 0));

            $sheet->setCellValue('A'.$row, $stt);
            $sheet->setCellValue('B'.$row, $p->ho_ten_snapshot);
            $sheet->setCellValue('C'.$row, $p->ma_nhan_vien_snapshot);
            $sheet->setCellValue('D'.$row, $tongCong);
            $sheet->setCellValue('E'.$row, $p->so_ngay_co_luong);
            $sheet->setCellValue('F'.$row, $p->so_ngay_khong_luong);
            $sheet->setCellValue('G'.$row, $p->luong_co_ban);
            $sheet->setCellValue('H'.$row, $p->tro_cap);
            $sheet->setCellValue('I'.$row, $p->nang_suat);
            $sheet->setCellValue('J'.$row, $p->thuong_khac);
            $sheet->setCellValue('K'.$row, $p->tong_thu_nhap);
            $sheet->setCellValue('L'.$row, $p->bhxh);
            $sheet->setCellValue('M'.$row, $p->bhyt);
            $sheet->setCellValue('N'.$row, $p->bhtn);
            $sheet->setCellValue('O'.$row, $p->tong_khau_tru);
            $sheet->setCellValue('P'.$row, $p->cong_tac_phi);
            $sheet->setCellValue('Q'.$row, $p->tam_ung);
            $sheet->setCellValue('R'.$row, $p->thu_nhap_chiu_thue);
            $sheet->setCellValue('S'.$row, $p->giam_tru_gia_canh);
            $sheet->setCellValue('T'.$row, $p->thue_tncn);
            $sheet->setCellValue('U'.$row, $p->luong_thuc_nhan);

            $row++;
            $stt++;
        }

        $dongDauCuoi = $row - 1;
        $sheet->setCellValue('A'.$row, 'Tổng');
        $sheet->mergeCells('A'.$row.':C'.$row);

        if ($dongDauCuoi >= 5) {
            $tongCols = ['D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U'];
            $truongTheoCot = [
                'D' => null, 'E' => 'so_ngay_co_luong', 'F' => 'so_ngay_khong_luong',
                'G' => 'luong_co_ban', 'H' => 'tro_cap', 'I' => 'nang_suat', 'J' => 'thuong_khac',
                'K' => 'tong_thu_nhap', 'L' => 'bhxh', 'M' => 'bhyt', 'N' => 'bhtn', 'O' => 'tong_khau_tru',
                'P' => 'cong_tac_phi', 'Q' => 'tam_ung', 'R' => 'thu_nhap_chiu_thue', 'S' => 'giam_tru_gia_canh',
                'T' => 'thue_tncn', 'U' => 'luong_thuc_nhan',
            ];

            foreach ($tongCols as $col) {
                if ($col === 'D') {
                    $tong = $phieus->sum(fn ($p) => $p->ngay_cong_chuan ?? (($p->so_ngay_co_luong ?? 0) + ($p->so_ngay_khong_luong ?? 0)));
                } else {
                    $tong = $phieus->sum($truongTheoCot[$col]);
                }
                $sheet->setCellValue($col.$row, $tong);
            }
        }

        $sheet->getStyle('A5:U'.$row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $tienCols = ['G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U'];
        foreach ($tienCols as $col) {
            $sheet->getStyle($col.'5:'.$col.$row)->getNumberFormat()->setFormatCode('#,##0');
        }

        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(14);
        foreach (['D', 'E', 'F'] as $col) {
            $sheet->getColumnDimension($col)->setWidth(10);
        }
        foreach (['G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U'] as $col) {
            $sheet->getColumnDimension($col)->setWidth(14);
        }

        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $path = storage_path('app/tmp_phieuluong_nv_'.uniqid().'.xlsx');
        (new Xlsx($spreadsheet))->save($path);

        return $path;
    }
}
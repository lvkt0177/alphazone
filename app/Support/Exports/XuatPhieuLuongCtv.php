<?php

namespace App\Support\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class XuatPhieuLuongCtv
{
    public static function taoFile(Collection $phieus, Carbon $thang): string
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Thang '.$thang->format('m-Y'));

        $sheet->setCellValue('A1', 'BẢNG THANH TOÁN TIỀN THUÊ CỘNG TÁC VIÊN');
        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(13);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Họ và tên người thuê:');
        $sheet->setCellValue('C3', 'Công ty TNHH Alpha Kids Football Club');
        $sheet->setCellValue('A4', 'Bộ phận (hoặc địa chỉ):');
        $sheet->setCellValue('C4', '63 Quốc Lộ 20, xã Đức Trọng, tỉnh Lâm Đồng');
        $sheet->setCellValue('A5', 'Nội dung thuê:');
        $sheet->setCellValue('C5', 'CTV hỗ trợ bóng đá');
        $sheet->setCellValue('A6', 'Thời gian:');
        $sheet->setCellValue('C6', 'Tháng '.$thang->format('n/Y'));
        $sheet->getStyle('A3:A6')->getFont()->setBold(true);

        $tieuDe = ['A' => 'STT', 'B' => 'Họ và tên người được thuê', 'C' => 'Địa chỉ/CMND',
            'D' => 'Nội dung công việc', 'E' => 'Số giờ', 'F' => 'Đơn giá', 'G' => 'Thành tiền',
            'H' => 'Khấu trừ', 'I' => 'Thực nhận', 'J' => 'Ký nhận'];
        foreach ($tieuDe as $col => $ten) {
            $sheet->setCellValue($col.'8', $ten);
        }
        $sheet->getStyle('A8:J8')->getFont()->setBold(true);
        $sheet->getStyle('A8:J8')->getAlignment()->setWrapText(true)->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A8:J8')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $row = 9;
        $stt = 1;
        foreach ($phieus as $p) {
            $sheet->setCellValue('A'.$row, $stt);
            $sheet->setCellValue('B'.$row, $p->ho_ten_snapshot);
            $sheet->setCellValue('C'.$row, $p->ma_nhan_vien_snapshot);
            $sheet->setCellValue('D'.$row, 'CTV hỗ trợ bóng đá');
            $sheet->setCellValue('E'.$row, $p->tong_so_gio);
            $sheet->setCellValue('F'.$row, $p->don_gia);
            $sheet->setCellValue('G'.$row, "=E{$row}*F{$row}");
            $sheet->setCellValue('H'.$row, $p->khau_tru);
            $sheet->setCellValue('I'.$row, "=G{$row}-H{$row}");

            $row++;
            $stt++;
        }

        $dongDauCuoi = $row - 1;
        $sheet->setCellValue('A'.$row, 'Tổng Cộng');
        $sheet->mergeCells('A'.$row.':D'.$row);

        if ($dongDauCuoi >= 9) {
            foreach (['E', 'F', 'G', 'H', 'I'] as $col) {
                $sheet->setCellValue($col.$row, "=SUM({$col}9:{$col}{$dongDauCuoi})");
            }
        }

        $sheet->getStyle('A9:J'.$row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        foreach (['F', 'G', 'H', 'I'] as $col) {
            $sheet->getStyle($col.'9:'.$col.$row)->getNumberFormat()->setFormatCode('#,##0');
        }

        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(16);
        $sheet->getColumnDimension('D')->setWidth(18);
        foreach (['E', 'F', 'G', 'H', 'I', 'J'] as $col) {
            $sheet->getColumnDimension($col)->setWidth(13);
        }

        $path = storage_path('app/tmp_phieuluong_ctv_'.uniqid().'.xlsx');
        (new Xlsx($spreadsheet))->save($path);

        return $path;
    }
}
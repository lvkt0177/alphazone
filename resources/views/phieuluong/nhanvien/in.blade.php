<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phiếu lương Nhân viên - {{ $phieu->ho_ten_snapshot }} - Tháng {{ $thang->format('m/Y') }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1E293B;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            background: #fff;
            font-size: 13px;
        }
        .a4-page {
            width: 100%;
            max-width: 210mm;
            margin: 0 auto;
            box-sizing: border-box;
            background: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 16px;
            border-bottom: 2px solid #0F172A;
            padding-bottom: 10px;
        }
        .company-name {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            color: #334155;
            letter-spacing: 0.5px;
        }
        .doc-title {
            font-size: 19px;
            font-weight: 800;
            text-transform: uppercase;
            color: #0F172A;
            margin: 6px 0 2px 0;
        }
        .doc-sub {
            font-size: 13px;
            color: #64748B;
            font-weight: 600;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 20px;
            margin-bottom: 14px;
            font-size: 13px;
            background: #F8FAFC;
            padding: 10px 14px;
            border-radius: 8px;
            border: 1px solid #E2E8F0;
        }
        .info-item span {
            color: #64748B;
        }
        .info-item b {
            color: #0F172A;
        }
        table.sheet-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
            font-size: 12.5px;
        }
        table.sheet-table th, table.sheet-table td {
            border: 1px solid #CBD5E1;
            padding: 5px 10px;
            text-align: left;
        }
        table.sheet-table th {
            background: #F1F5F9;
            color: #0F172A;
            font-weight: 700;
        }
        table.sheet-table td.num, table.sheet-table th.num {
            text-align: right;
        }
        .total-row {
            font-weight: 700;
            background: #F8FAFC;
        }
        .final-row {
            font-size: 14.5px;
            font-weight: 800;
            background: #EEF2FF;
            color: #000000;
        }
        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-top: 24px;
            text-align: center;
            font-size: 13px;
        }
        .sig-box b {
            display: block;
            margin-bottom: 45px;
            color: #0F172A;
        }
        .sig-box span {
            color: #64748B;
            font-size: 11px;
            font-style: italic;
        }
        .print-actions {
            text-align: center;
            margin-bottom: 20px;
            margin-top: 10px;
        }
        .btn-print {
            background: #C2452E;
            color: #fff;
            border: none;
            padding: 10px 24px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-print:hover {
            background: #A63B25;
        }
        @media print {
            .print-actions {
                display: none;
            }
            body {
                background: #fff;
            }
        }
    </style>
</head>
<body>
    <div class="print-actions">
        <button class="btn-print" onclick="window.print()"><i class="ri-printer-line"></i> In / Tải phiếu lương A4</button>
    </div>

    <div class="a4-page">
        <div class="header">
            <div class="company-name">Hệ thống quản lý trung tâm Alphazone</div>
            <div class="doc-title">Phiếu Lương Nhân Viên Chính Thức</div>
            <div class="doc-sub">Tháng {{ $thang->format('m/Y') }}</div>
        </div>

        <div class="info-grid">
            <div class="info-item"><span>Họ và tên:</span> <b>{{ $phieu->ho_ten_snapshot }}</b></div>
            <div class="info-item"><span>Mã nhân viên / CCCD:</span> <b>{{ $phieu->ma_nhan_vien_snapshot ?? '---' }}</b></div>
            <div class="info-item"><span>Ngày công chuẩn:</span> <b>{{ $phieu->ngay_cong_chuan ?? 0 }} ngày</b></div>
            <div class="info-item"><span>Ngày công thực tế:</span> <b>Có: {{ $phieu->so_ngay_co_luong }} ngày · Không: {{ $phieu->so_ngay_khong_luong }} ngày</b></div>
        </div>

        <table class="sheet-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Khoản mục chi tiết</th>
                    <th class="num">Số tiền (VNĐ)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Lương cơ bản</td>
                    <td class="num">{{ number_format($phieu->luong_co_ban, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Trợ cấp (Xăng xe, điện thoại, hỗ trợ đứng lớp...)</td>
                    <td class="num">{{ number_format($phieu->tro_cap ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Năng suất công việc</td>
                    <td class="num">{{ number_format($phieu->nang_suat ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Thưởng khác</td>
                    <td class="num">{{ number_format($phieu->thuong_khac ?? 0, 0, ',', '.') }}</td>
                </tr>
                @php
                    $soNgayThieu = max(0, ($phieu->ngay_cong_chuan ?? 0) - $phieu->so_ngay_co_luong);
                    $tienTru1Ngay = $phieu->giaoVien?->tienTru1NgayHieuLuc() ?? 0;
                    $truNgayThieu = $soNgayThieu * $tienTru1Ngay;
                @endphp
                @if ($truNgayThieu > 0)
                <tr>
                    <td>5</td>
                    <td>Trừ ngày công thiếu ({{ $soNgayThieu }} ngày)</td>
                    <td class="num" style="color: #DC2626;">-{{ number_format($truNgayThieu, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td colspan="2"><b>I. Tổng thu nhập</b></td>
                    <td class="num"><b>{{ number_format($phieu->tong_thu_nhap, 0, ',', '.') }}</b></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Bảo hiểm XH (8%) {!! $phieu->ap_dung_bhxh ? '' : '<span style="color:#94A3B8">(Không áp dụng)</span>' !!}</td>
                    <td class="num" style="color: #DC2626;">-{{ number_format($phieu->bhxh ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Bảo hiểm YT (1.5%) {!! $phieu->ap_dung_bhyt ? '' : '<span style="color:#94A3B8">(Không áp dụng)</span>' !!}</td>
                    <td class="num" style="color: #DC2626;">-{{ number_format($phieu->bhyt ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Bảo hiểm TN (1%) {!! $phieu->ap_dung_bhtn ? '' : '<span style="color:#94A3B8">(Không áp dụng)</span>' !!}</td>
                    <td class="num" style="color: #DC2626;">-{{ number_format($phieu->bhtn ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="2"><b>II. Tổng khấu trừ bảo hiểm</b></td>
                    <td class="num" style="color: #DC2626;"><b>-{{ number_format($phieu->tong_khau_tru, 0, ',', '.') }}</b></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>Tạm ứng lương</td>
                    <td class="num">{{ number_format($phieu->tam_ung ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>Công tác phí</td>
                    <td class="num">{{ number_format($phieu->cong_tac_phi ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>11</td>
                    <td>Thuế TNCN</td>
                    <td class="num" style="color: #DC2626;">-{{ number_format($phieu->thue_tncn ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr class="final-row">
                    <td colspan="2"><b>THỰC NHẬN (LƯƠNG THỰC LĨNH)</b></td>
                    <td class="num"><b>{{ number_format($phieu->luong_thuc_nhan, 0, ',', '.') }} đ</b></td>
                </tr>
            </tbody>
        </table>

        <div class="signatures">
            <div class="sig-box">
                <b>Người lập phiếu</b>
                <span>(Ký, ghi rõ họ tên)</span>
            </div>
            <div class="sig-box">
                <b>Kế toán trưởng / Quản lý</b>
                <span>(Ký, ghi rõ họ tên)</span>
            </div>
            <div class="sig-box">
                <b>Nhân viên nhận lương</b>
                <span>(Ký, ghi rõ họ tên)</span>
            </div>
        </div>
    </div>
</body>
</html>

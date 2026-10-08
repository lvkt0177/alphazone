<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phiếu lương Cộng tác viên - {{ $phieu->ho_ten_snapshot }} - Tháng {{ $thang->format('m/Y') }}</title>
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
            padding: 6px 10px;
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
        .final-row {
            font-size: 14.5px;
            font-weight: 800;
            background: #EEF2FF;
            color: #000000;
        }
        .lichsu-section {
            margin-bottom: 16px;
        }
        .lichsu-title {
            font-size: 13px;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 6px;
        }
        .ngay-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }
        .ngay-cell {
            border: 1px solid #CBD5E1;
            border-radius: 4px;
            padding: 4px 2px;
            text-align: center;
            font-size: 11px;
            background: #F8FAFC;
        }
        .ngay-cell.active {
            background: #DCFCE7;
            border-color: #22C55E;
            color: #15803D;
            font-weight: 700;
        }
        .ngay-cell .ngay-so {
            font-size: 12px;
            font-weight: 700;
        }
        .ngay-cell .ngay-gio {
            font-size: 9.5px;
            margin-top: 1px;
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
            <div class="doc-title">Phiếu Lương Cộng Tác Viên (Trợ Giảng)</div>
            <div class="doc-sub">Tháng {{ $thang->format('m/Y') }}</div>
        </div>

        <div class="info-grid">
            <div class="info-item"><span>Họ và tên:</span> <b>{{ $phieu->ho_ten_snapshot }}</b></div>
            <div class="info-item"><span>Mã nhân viên / CCCD:</span> <b>{{ $phieu->ma_nhan_vien_snapshot ?? '---' }}</b></div>
            <div class="info-item"><span>Tổng số giờ dạy:</span> <b>{{ rtrim(rtrim(number_format($phieu->tong_so_gio, 1), '0'), '.') }} giờ</b></div>
            <div class="info-item"><span>Đơn giá/giờ:</span> <b>{{ number_format($phieu->don_gia, 0, ',', '.') }} đ/giờ</b></div>
        </div>

        <div class="lichsu-section">
            <div class="lichsu-title">Lịch sử ngày đi làm trong tháng (🟢 Có dạy / ⚪ Nghỉ):</div>
            <div class="ngay-grid">
                @foreach ($chiTietNgay as $item)
                    <div class="ngay-cell {{ $item['co_lam'] ? 'active' : '' }}">
                        <div class="ngay-so">{{ $item['ngay'] }}</div>
                        <div class="ngay-gio">{{ $item['co_lam'] ? $item['so_gio'] . 'h' : '-' }}</div>
                    </div>
                @endforeach
            </div>
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
                    <td>Thành tiền dạy học ({{ rtrim(rtrim(number_format($phieu->tong_so_gio, 1), '0'), '.') }} giờ × {{ number_format($phieu->don_gia, 0, ',', '.') }} đ)</td>
                    <td class="num">{{ number_format($phieu->thanh_tien, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Trợ cấp xăng xe (từ chấm công)</td>
                    <td class="num">{{ number_format($phieu->tro_cap ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Khấu trừ</td>
                    <td class="num" style="color: #DC2626;">-{{ number_format($phieu->khau_tru ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr class="final-row">
                    <td colspan="2"><b>THỰC NHẬN (LƯƠNG THỰC LĨNH)</b></td>
                    <td class="num"><b>{{ number_format($phieu->thuc_nhan, 0, ',', '.') }} đ</b></td>
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
                <b>Cộng tác viên nhận lương</b>
                <span>(Ký, ghi rõ họ tên)</span>
            </div>
        </div>
    </div>
</body>
</html>

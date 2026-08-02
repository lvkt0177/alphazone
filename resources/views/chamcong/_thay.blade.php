<div class="breadcrumb">
    <a>Chấm công</a>
    <i class="ri-arrow-right-s-line"></i>
    <a class="active">Thầy phụ trách</a>
</div>
<div class="page-head">
    <div class="page-title">Chấm công - Thầy phụ trách</div>
</div>

@if (session('success'))
    <div class="badge green chamcong-alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="badge red chamcong-alert-error">{{ session('error') }}</div>
@endif

<div class="table-card">
    <form method="GET" action="{{ route('chamcong.thay') }}" class="chamcong-toolbar">
        <div class="filters">
            <div class="field chamcong-filter-field--date">
                <label class="chamcong-filter-label">Ngày chấm công</label>
                <input type="date" name="ngay" value="{{ $ngay }}" max="{{ now()->toDateString() }}"
                    onchange="this.form.submit()">
            </div>
        </div>

        <div class="thong-tin-cham-cong">
            <div class="text-2 chamcong-status-line">
                Đang chấm công ngày <b>{{ \Carbon\Carbon::parse($ngay)->format('d/m/Y') }}</b>
            </div>
            <div class="text-2 chamcong-status-line">
                <span class="badge green">Có đi làm: {{ $soCo }}</span>
                <span class="badge red">Không đi làm: {{ $soKhong }}</span>
            </div>
        </div>
    </form>

    <form method="POST" action="{{ route('chamcong.thay.luu') }}">
        @csrf
        <input type="hidden" name="ngay" value="{{ $ngay }}">

        <table>
            <thead>
                <tr>
                    <th>Thầy phụ trách</th>
                    <th>Có đi làm</th>
                    <th>Hỗ trợ xăng xe</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($thayPhuTrachs as $gv)
                    @php $rec = $existing->get($gv->id); @endphp
                    <tr>
                        <td>{{ $gv->ho_ten }}</td>
                        <td>
                            <input type="hidden" name="rows[{{ $gv->id }}][co_di_lam]" id="cdl_{{ $gv->id }}"
                                value="{{ $rec && $rec->co_di_lam !== null ? ($rec->co_di_lam ? '1' : '0') : '' }}">
                            <div class="chamcong-pill-group">
                                <button type="button"
                                    class="chamcong-pill chamcong-pill--co {{ $rec && $rec->co_di_lam === true ? 'active' : '' }}"
                                    onclick="chonCoKhong({{ $gv->id }}, '1')">Có</button>
                                <button type="button"
                                    class="chamcong-pill chamcong-pill--khong {{ $rec && $rec->co_di_lam === false ? 'active' : '' }}"
                                    onclick="chonCoKhong({{ $gv->id }}, '0')">Không</button>
                            </div>
                        </td>
                        <td>
                            <input type="text" id="htx_display_{{ $gv->id }}" class="chamcong-hotro-input"
                                inputmode="numeric" autocomplete="off" placeholder="0"
                                value="{{ $rec && $rec->ho_tro_xang_xe !== null ? number_format($rec->ho_tro_xang_xe, 0, ',', '.') : '' }}">
                            <input type="hidden" name="rows[{{ $gv->id }}][ho_tro_xang_xe]" id="htx_{{ $gv->id }}"
                                value="{{ $rec->ho_tro_xang_xe ?? '' }}">
                        </td>
                        <td>
                            <input type="text" name="rows[{{ $gv->id }}][ghi_chu]" class="chamcong-ghichu-input"
                                value="{{ $rec->ghi_chu ?? '' }}" placeholder="Tuỳ chọn...">
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-2 chamcong-empty-row">Chưa có giáo viên nào giữ chức danh Thầy
                            phụ trách</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if (hasQuyen('chamcong', 'them') && $thayPhuTrachs->isNotEmpty())
            <div class="chamcong-form-actions">
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu</button>
            </div>
        @endif
    </form>
</div>
<div class="overlay" id="branchModal">
    <div class="modal">
        <div class="modal-head">
            <h3 id="branchModalTitle">Tạo Cơ sở</h3><i class="ri-close-line" onclick="closeModal('branchModal')"></i>
        </div>

        <form id="branchForm" method="POST" action="{{ route('coso.store') }}" data-store-url="{{ route('coso.store') }}"
            data-update-url-base="{{ url('coso') }}">
            @csrf
            <div id="branchMethodField"></div>
            <input type="hidden" name="_editing_id" id="branchEditingId">

            <div class="modal-body">
                <div class="form-grid full">
                    <div class="field">
                        <label>Tên cơ sở</label>
                        <input id="br_name" name="ten" type="text" placeholder="VD: Liên Nghĩa T3">
                        @error('ten')
                            <div class="badge red branches-field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    @if (empty($giaoViens))
                        <div class="badge red branches-field-error">Không có giáo viên nào để chọn làm người phụ
                            trách. Vui lòng thêm giáo viên trước.</div>
                    @else
                        <div class="field">
                            <label>Người phụ trách</label>
                            <select id="br_teacher" name="giao_vien_id">
                                <option value="">-- Chọn giáo viên --</option>
                                @foreach ($giaoViens as $gv)
                                    <option value="{{ $gv->id }}">{{ $gv->ho_ten }}</option>
                                @endforeach
                            </select>
                            @error('giao_vien_id')
                                <div class="badge red branches-field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    <div class="field">
                        <label>Địa điểm</label>
                        <select id="br_diadiem" name="dia_diem_id" onchange="toggleDiaDiemMoi(this.value)">
                            <option value="">-- Chưa gán --</option>
                            @foreach ($diaDiems as $dd)
                                <option value="{{ $dd->id }}">{{ $dd->ten }}</option>
                            @endforeach
                            <option value="new">+ Tạo địa điểm mới</option>
                        </select>
                        @error('dia_diem_id')
                            <div class="badge red branches-field-error">{{ $message }}</div>
                        @enderror

                        <div id="br_diadiem_moi_wrap" class="branches-diadiem-moi-wrap">
                            <input id="br_diadiem_moi" name="dia_diem_ten_moi" type="text"
                                placeholder="Tên địa điểm mới">
                            @error('dia_diem_ten_moi')
                                <div class="badge red branches-field-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('branchModal')">Huỷ</button>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu Cơ sở</button>
            </div>
        </form>
    </div>
</div>
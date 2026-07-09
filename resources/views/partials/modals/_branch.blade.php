<div class="overlay" id="branchModal">
    <div class="modal">
        <div class="modal-head">
            <h3 id="branchModalTitle">Tạo Cơ sở</h3><i class="ri-close-line" onclick="closeModal('branchModal')"></i>
        </div>

        <form id="branchForm" method="POST" action="{{ route('coso.store') }}" data-store-url="{{ route('coso.store') }}"
            data-update-url-base="{{ url('coso') }}">
            @csrf
            <div id="branchMethodField"></div>

            @if (empty($giaoViens))
                <div class="badge red" style="margin:10px 0;">Không có giáo viên nào để chọn làm người phụ trách. Vui
                    lòng thêm giáo viên trước.</div>
            @else
                <div class="modal-body">
                    <div class="form-grid full">
                        <div class="field">
                            <label>Tên cơ sở</label>
                            <input id="br_name" name="ten" type="text"
                                placeholder="VD: Liên Nghĩa T3">
                        </div>
                        <div class="field">
                            <label>Người phụ trách</label>
                            <select id="br_teacher" name="giao_vien_id">
                                @foreach ($giaoViens as $gv)
                                    <option value="{{ $gv->id }}">{{ $gv->ho_ten }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @error('ten')
                  <div class="badge red" style="margin-top:10px;">{{ $message }}</div>
                @enderror
            @endif
    </div>
    <div class="modal-foot">
        <button type="button" class="btn btn-outline" onclick="closeModal('branchModal')">Huỷ</button>
        <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu Cơ sở</button>
    </div>
    </form>
</div>
</div>

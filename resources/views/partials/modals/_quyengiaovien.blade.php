<div class="overlay" id="quyenModal">
    <div class="modal">
        <div class="modal-head">
            <h3>Cấp quyền cho: <span id="quyenGvName"></span></h3>
            <i class="ri-close-line" onclick="closeModal('quyenModal')"></i>
        </div>

        <form id="quyenForm" method="POST" action="" data-save-url-base="{{ url('giaovien') }}">
            @csrf
            <div class="modal-body">
                <table class="quyen-table">
                    <thead>
                        <tr>
                            <th>Chức năng</th>
                            <th>Xem</th>
                            <th>Thêm</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chucNangs as $cn)
                            <tr>
                                <td>{{ $cn->ten }}</td>
                                <td><input type="checkbox" name="quyen[{{ $cn->id }}][xem]"
                                        id="qgv_{{ $cn->id }}_xem" value="1"></td>
                                <td><input type="checkbox" name="quyen[{{ $cn->id }}][them]"
                                        id="qgv_{{ $cn->id }}_them" value="1"></td>
                                <td><input type="checkbox" name="quyen[{{ $cn->id }}][sua]"
                                        id="qgv_{{ $cn->id }}_sua" value="1"></td>
                                <td><input type="checkbox" name="quyen[{{ $cn->id }}][xoa]"
                                        id="qgv_{{ $cn->id }}_xoa" value="1"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-outline" onclick="closeModal('quyenModal')">Huỷ</button>
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu quyền</button>
            </div>
        </form>
    </div>
</div>

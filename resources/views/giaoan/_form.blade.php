<input type="hidden" name="cap_hoc" value="{{ $capHoc->value }}">
<input type="hidden" name="loai_game" value="{{ $loaiGame->value }}">
@if ($chuDe)
    <input type="hidden" name="chu_de" value="{{ $chuDe->value }}">
@endif

<div class="giaoan-context-line text-2">
    {{ $capHoc->getLabel() }} / {{ $loaiGame->getLabel() }}
    @if ($chuDe)
        / {{ $chuDe->getLabelCoSo() }}
    @endif
</div>

<div class="form-grid">
    <div class="field span-2">
        <label>Tên trò chơi</label>
        <input name="ten_tro_choi" type="text" value="{{ old('ten_tro_choi', $giaoAn->ten_tro_choi ?? '') }}">
        @error('ten_tro_choi')
            <div class="badge red giaoan-field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="field span-2">
        <label>Cách chơi</label>
        <textarea name="cach_choi" rows="4">{{ old('cach_choi', $giaoAn->cach_choi ?? '') }}</textarea>
        @error('cach_choi')
            <div class="badge red giaoan-field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="field span-2">
        <label>Luật chơi</label>
        <textarea name="luat_choi" rows="4">{{ old('luat_choi', $giaoAn->luat_choi ?? '') }}</textarea>
        @error('luat_choi')
            <div class="badge red giaoan-field-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="field span-2">
        <label>Sơ đồ</label>
        @include('giaoan._sodo_designer')
        <input type="hidden" name="so_do" id="ga_so_do"
            value="{{ old('so_do', isset($giaoAn) && $giaoAn->so_do ? json_encode($giaoAn->so_do) : '') }}">
    </div>

    <div class="field span-2">
        <label>Tải video lên</label>
        <input type="file" name="video" accept="video/*">
        @if (isset($giaoAn) && $giaoAn->video_path)
            <div class="text-2 giaoan-current-video">
                Video hiện tại: <a href="{{ $giaoAn->videoUrl() }}" target="_blank">Xem video</a>
            </div>
        @endif
        @error('video')
            <div class="badge red giaoan-field-error">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-actions">
    <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Lưu Giáo án</button>
    <a href="{{ route('giaoan.index', ['cap_hoc' => $capHoc->value, 'loai_game' => $loaiGame->value, 'chu_de' => $chuDe?->value]) }}"
        class="btn btn-outline">Huỷ</a>
</div>
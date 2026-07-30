@php
    $filters = ['cap_hoc' => $capHoc->value, 'loai_game' => $loaiGame->value, 'chu_de' => $chuDe?->value];
@endphp

<div class="breadcrumb">
    <a href="{{ route('giaoan.menu') }}">Giáo án</a>
    <i class="ri-arrow-right-s-line"></i>
    <a href="{{ route('giaoan.menu', ['cap_hoc' => $capHoc->value]) }}">{{ $capHoc->getLabel() }}</a>
    <i class="ri-arrow-right-s-line"></i>
    @if ($chuDe)
        <a href="{{ route('giaoan.menu', ['cap_hoc' => $capHoc->value, 'loai_game' => $loaiGame->value]) }}">{{ $loaiGame->getLabel() }}</a>
        <i class="ri-arrow-right-s-line"></i>
        <a class="active">{{ $chuDe->getLabelCoSo() }}</a>
    @else
        <a class="active">{{ $loaiGame->getLabel() }}</a>
    @endif
</div>

<div class="page-head">
    <div class="page-title">
        Danh sách Giáo án — {{ $capHoc->getLabel() }} / {{ $loaiGame->getLabel() }}
        @if ($chuDe)
            / {{ $chuDe->getLabelCoSo() }}
        @endif
    </div>
    @if (hasQuyen('giaoan', 'them'))
        <a href="{{ route('giaoan.create', $filters) }}" class="btn btn-primary"><i class="ri-add-line"></i> Tạo Giáo
            án</a>
    @endif
</div>

@if (session('success'))
    <div class="badge green giaoan-alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="badge red giaoan-alert-error">{{ session('error') }}</div>
@endif

<div class="table-card">
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên trò chơi</th>
                <th>Cách chơi</th>
                <th>Sơ đồ</th>
                <th>Video</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($giaoAns as $ga)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="giaoan-name-cell">
                        <a href="{{ route('giaoan.show', $ga) }}" target="_blank"
                            class="giaoan-name-link">{{ $ga->ten_tro_choi }}</a>
                    </td>
                    <td class="text-2 giaoan-desc-cell">
                        {{ $ga->cach_choi ? \Illuminate\Support\Str::limit($ga->cach_choi, 80) : '—' }}</td>
                    <td>
                        @include('giaoan._sodo_thumb', ['ga' => $ga])
                    </td>
                    <td>
                        @if ($ga->video_path)
                            <a href="{{ $ga->videoUrl() }}" target="_blank" class="badge green giaoan-video-badge">
                                <i class="ri-play-circle-line"></i> Xem video
                            </a>
                        @else
                            <span class="text-2">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions-cell">
                            <a href="{{ route('giaoan.show', $ga) }}" target="_blank" title="Xem chi tiết"><i
                                    class="ri-eye-line"></i></a>
                            @if (hasQuyen('giaoan', 'sua'))
                                <a href="{{ route('giaoan.edit', $ga) }}"><i class="ri-edit-line"></i></a>
                            @endif
                            @if (hasQuyen('giaoan', 'xoa'))
                                <form action="{{ route('giaoan.destroy', $ga) }}" method="POST"
                                    class="giaoan-inline-form confirm-delete-form" data-confirm-title="Xoá giáo án"
                                    data-confirm-message="Bạn có chắc muốn xoá giáo án {{ $ga->ten_tro_choi }}?">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="giaoan-icon-btn"><i
                                            class="ri-delete-bin-line del"></i></button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-2 giaoan-empty-row">Chưa có giáo án nào</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        @if (!$giaoAns->onFirstPage())
            <a href="{{ $giaoAns->previousPageUrl() }}">Trước</a>
        @else
            <span class="giaoan-page-disabled">Trước</span>
        @endif
        @for ($i = 1; $i <= $giaoAns->lastPage(); $i++)
            <a href="{{ $giaoAns->url($i) }}"
                class="{{ $i == $giaoAns->currentPage() ? 'active' : '' }}">{{ $i }}</a>
        @endfor
        @if ($giaoAns->hasMorePages())
            <a href="{{ $giaoAns->nextPageUrl() }}">Sau</a>
        @else
            <span class="giaoan-page-disabled">Sau</span>
        @endif
    </div>
</div>
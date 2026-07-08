@extends('layouts.admin')
@section('title', 'Chi tiết Học viên')
@section('content')
    @include('students._detail')
@endsection

@push('scripts')
<script>
    // Khi vào thẳng URL /hoc-vien/{id} (đa trang), tự động đổ dữ liệu học viên đó lên giao diện.
    // Lưu ý: app.js bản demo dùng mảng "students" giả lập phía client (id 1..24).
    // Khi nối API/DB thật, hãy thay hàm openStudentDetail(id) để gọi API lấy đúng học viên theo $id.
    document.addEventListener('DOMContentLoaded', function () {
        const routeId = {{ (int) ($id ?? 1) }};
        if (typeof openStudentDetail === 'function') {
            openStudentDetail(routeId);
        }
    });
</script>
@endpush

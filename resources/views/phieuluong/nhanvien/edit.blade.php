@extends('layouts.admin')
@section('title', 'Sửa phiếu lương Nhân viên chính thức')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/phieuluong.css') }}">
    @endpush

    @include('phieuluong.nhanvien._edit')

    @push('scripts')
        <script src="{{ asset('js/pages/phieuluongnhanvien.js') }}"></script>
    @endpush
@endsection

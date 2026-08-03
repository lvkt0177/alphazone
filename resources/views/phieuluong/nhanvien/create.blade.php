@extends('layouts.admin')
@section('title', 'Tạo phiếu lương Nhân viên chính thức')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/phieuluong.css') }}">
    @endpush

    @include('phieuluong.nhanvien._create')

    @push('scripts')
        <script src="{{ asset('js/pages/phieuluongnhanvien.js') }}"></script>
    @endpush
@endsection
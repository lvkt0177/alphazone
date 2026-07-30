@extends('layouts.admin')
@section('title', 'Tạo Giáo án')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/giaoan.css') }}">
    @endpush

    @php
        $filters = ['cap_hoc' => $capHoc->value, 'loai_game' => $loaiGame->value, 'chu_de' => $chuDe?->value];
    @endphp

    <div class="breadcrumb">
        <a href="{{ route('giaoan.index', $filters) }}">Danh sách Giáo án</a>
        <i class="ri-arrow-right-s-line"></i>
        <a class="active">Tạo Giáo án</a>
    </div>
    <div class="page-head">
        <div class="page-title">Tạo Giáo án mới</div>
    </div>

    <form class="form-card" method="POST" action="{{ route('giaoan.store') }}" enctype="multipart/form-data">
        @csrf
        @include('giaoan._form', ['capHoc' => $capHoc, 'loaiGame' => $loaiGame, 'chuDe' => $chuDe])
    </form>

    @push('scripts')
        <script src="{{ asset('js/pages/giaoan-form.js') }}"></script>
    @endpush
@endsection
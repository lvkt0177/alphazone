@extends('layouts.admin')
@section('title', 'Sửa Giáo án')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/giaoan.css') }}">
    @endpush

    @php
        $capHoc = $giaoAn->cap_hoc;
        $loaiGame = $giaoAn->loai_game;
        $chuDe = $giaoAn->chu_de;
        $filters = ['cap_hoc' => $capHoc->value, 'loai_game' => $loaiGame->value, 'chu_de' => $chuDe?->value];
    @endphp

    <div class="breadcrumb">
        <a href="{{ route('giaoan.index', $filters) }}">Danh sách Giáo án</a>
        <i class="ri-arrow-right-s-line"></i>
        <a class="active">Sửa Giáo án</a>
    </div>
    <div class="page-head">
        <div class="page-title">Sửa Giáo án — {{ $giaoAn->ten_tro_choi }}</div>
    </div>

    <form class="form-card" method="POST" action="{{ route('giaoan.update', $giaoAn) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('giaoan._form', ['capHoc' => $capHoc, 'loaiGame' => $loaiGame, 'chuDe' => $chuDe, 'giaoAn' => $giaoAn])
    </form>

    @push('scripts')
        <script src="{{ asset('js/pages/giaoan-form.js') }}"></script>
    @endpush
@endsection
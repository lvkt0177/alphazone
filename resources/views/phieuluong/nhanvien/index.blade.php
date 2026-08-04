@extends('layouts.admin')
@section('title', 'Phiếu lương Nhân viên chính thức')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/phieuluong.css') }}">
    @endpush

    @include('phieuluong.nhanvien._index')
@endsection

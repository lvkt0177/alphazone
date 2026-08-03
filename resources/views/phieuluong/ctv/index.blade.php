@extends('layouts.admin')
@section('title', 'Phiếu lương Cộng tác viên')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/phieuluong.css') }}">
    @endpush

    @include('phieuluong.ctv._index')
@endsection
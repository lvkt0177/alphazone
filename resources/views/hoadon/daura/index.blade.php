@extends('layouts.admin')
@section('title', 'Hóa đơn đầu ra')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/hoadon.css') }}">
    @endpush

    @include('hoadon.daura._index')
@endsection

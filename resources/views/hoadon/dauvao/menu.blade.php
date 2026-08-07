@extends('layouts.admin')
@section('title', 'Hóa đơn đầu vào')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/hoadon.css') }}">
    @endpush

    @include('hoadon.dauvao._menu')
@endsection

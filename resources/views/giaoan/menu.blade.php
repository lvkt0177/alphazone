@extends('layouts.admin')
@section('title', 'Giáo án')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/giaoan.css') }}">
    @endpush

    @include('giaoan._menu')
@endsection
@extends('layouts.admin')
@section('title', 'Biểu mẫu')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/bieumau.css') }}">
    @endpush

    @include('bieumau._menu')
@endsection
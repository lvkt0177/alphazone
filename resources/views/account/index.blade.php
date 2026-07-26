@extends('layouts.admin')
@section('title', 'Đổi mật khẩu')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/account.css') }}">
    @endpush

    @include('account._index')
@endsection
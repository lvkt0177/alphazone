@extends('layouts.admin')
@section('title', 'Quản lý Cơ sở')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/branches.css') }}">
    @endpush

    @include('branches._index')

    @push('scripts')
        <script src="{{ asset('js/pages/branches.js') }}"></script>
    @endpush
@endsection
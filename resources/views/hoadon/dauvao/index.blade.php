@extends('layouts.admin')
@section('title', $loaiHoaDon->getLabel())
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/hoadon.css') }}">
    @endpush

    @include('hoadon.dauvao._index')

    @push('scripts')
        <script src="{{ asset('js/pages/hoadon.js') }}"></script>
    @endpush
@endsection

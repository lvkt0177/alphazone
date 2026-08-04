@extends('layouts.admin')
@section('title', 'Tạo phiếu lương Cộng tác viên')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/phieuluong.css') }}">
    @endpush

    @include('phieuluong.ctv._create')

    @push('scripts')
        <script src="{{ asset('js/pages/phieuluongctv.js') }}"></script>
    @endpush
@endsection
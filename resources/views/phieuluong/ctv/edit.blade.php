@extends('layouts.admin')
@section('title', 'Sửa phiếu lương Cộng tác viên')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/phieuluong.css') }}">
    @endpush

    @include('phieuluong.ctv._edit')

    @push('scripts')
        <script src="{{ asset('js/pages/phieuluongctv.js') }}"></script>
    @endpush
@endsection
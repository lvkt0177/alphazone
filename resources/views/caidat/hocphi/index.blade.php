@extends('layouts.admin')
@section('title', 'Cấu hình Học phí')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/caidathocphi.css') }}">
    @endpush

    @include('caidat.hocphi._index')

    @push('scripts')
        <script src="{{ asset('js/pages/caidathocphi.js') }}"></script>
    @endpush
@endsection
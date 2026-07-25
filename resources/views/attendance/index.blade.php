@extends('layouts.admin')
@section('title', 'Điểm danh')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/attendance.css') }}">
    @endpush

    @include('attendance._index')

    @push('scripts')
        <script src="{{ asset('js/pages/attendance.js') }}"></script>
    @endpush
@endsection
@extends('layouts.admin')
@section('title', 'Điểm danh')
@section('content')
    @include('attendance._index')

    @push('scripts')
        <script src="{{ asset('js/pages/attendance.js') }}"></script>
    @endpush
@endsection

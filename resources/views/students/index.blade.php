@extends('layouts.admin')
@section('title', 'Danh sách Học viên')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/student.css') }}">
    @endpush
    
    @include('students._index')

    @push('scripts')
        <script src="{{ asset('js/pages/students.js') }}"></script>
    @endpush
@endsection

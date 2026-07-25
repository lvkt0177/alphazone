@extends('layouts.admin')
@section('title', 'Chi tiết Học viên')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/student.css') }}">
    @endpush

    @include('students._detail')
@endsection
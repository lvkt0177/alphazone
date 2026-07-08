@extends('layouts.admin')
@section('title', 'Quản lý Giáo viên')
@section('content')
    @include('teachers._index')

    @push('scripts')
        <script src="{{ asset('js/pages/teachers.js') }}"></script>
    @endpush
@endsection

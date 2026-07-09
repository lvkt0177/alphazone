@extends('layouts.admin')
@section('title', 'Quản lý Cơ sở')
@section('content')
    @include('branches._index')

    @push('scripts')
        <script src="{{ asset('js/pages/branches.js') }}"></script>
    @endpush
@endsection

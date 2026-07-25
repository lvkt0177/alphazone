@extends('layouts.admin')
@section('title', 'Tiền sân')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/tiensan.css') }}">
    @endpush

    @include('tiensan._index')

    @push('scripts')
    <script src="{{ asset('js/pages/tiensan.js') }}"></script>
    @endpush
@endsection
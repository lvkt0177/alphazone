@extends('layouts.admin')
@section('title', $loaiBieuMau->getLabel())
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/bieumau.css') }}">
    @endpush

    @include('bieumau._index')

    @push('scripts')
        <script src="{{ asset('js/pages/bieumau.js') }}"></script>
    @endpush
@endsection
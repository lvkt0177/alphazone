@extends('layouts.admin')
@section('title', 'Cấu hình Tiền lương')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/caidattienluong.css') }}">
    @endpush

    @include('caidat.tienluong._index')

    @push('scripts')
        <script src="{{ asset('js/pages/caidattienluong.js') }}"></script>
    @endpush
@endsection

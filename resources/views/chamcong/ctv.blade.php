@extends('layouts.admin')
@section('title', 'Chấm công - Cộng tác viên')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/chamcong.css') }}">
    @endpush

    @include('chamcong._ctv')

    @push('scripts')
        <script src="{{ asset('js/pages/chamcongctv.js') }}"></script>
    @endpush
@endsection
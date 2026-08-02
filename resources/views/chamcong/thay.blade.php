@extends('layouts.admin')
@section('title', 'Chấm công - Thầy phụ trách')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/chamcong.css') }}">
    @endpush

    @include('chamcong._thay')

    @push('scripts')
        <script src="{{ asset('js/pages/chamcongthay.js') }}"></script>
    @endpush
@endsection

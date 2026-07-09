@extends('layouts.admin')
@section('title', 'Trải nghiệm')
@section('content')
    @include('trial._index')

    @push('scripts')
        <script src="{{ asset('js/pages/trial.js') }}"></script>
    @endpush
@endsection

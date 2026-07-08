@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
    @include('_dashboard')
    
    @push('scripts')
    <script src="{{ asset('js/fake-data.js') }}"></script>
    <script src="{{ asset('js/pages/dashboard.js') }}"></script>
    @endpush
@endsection
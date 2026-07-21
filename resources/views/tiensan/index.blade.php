@extends('layouts.admin')
@section('title', 'Tiền sân')
@section('content')
    @include('tiensan._index')

    
    @push('scripts')
    <script src="{{ asset('js/pages/tiensan.js') }}"></script>
    @endpush
@endsection

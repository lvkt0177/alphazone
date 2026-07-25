@extends('layouts.admin')
@section('title', 'Học phí')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/tuition.css') }}">
    @endpush

    @include('tuition._index')

    @push('scripts')
        <script>
            window.__hocVienOptions = @json($hocVienOptions);
        </script>
        <script src="{{ asset('js/pages/tuition.js') }}"></script>
    @endpush
@endsection
@extends('layouts.admin')
@section('title', 'Học phí')
@section('content')
    @include('tuition._index')

    @push('scripts')
        <script src="{{ asset('js/pages/tuition.js') }}"></script>
    @endpush
@endsection

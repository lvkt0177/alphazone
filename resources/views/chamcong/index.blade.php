@extends('layouts.admin')
@section('title', 'Chấm công')
@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/pages/chamcong.css') }}">
    @endpush

    @include('chamcong._index')

    @push('scripts')
        <script>
            window.__ccThayOptions = @json($thayPhuTrachs->map(fn($g) => ['id' => $g->id, 'ho_ten' => $g->ho_ten]));
            window.__ccCtvOptions = @json($ctvs->map(fn($g) => ['id' => $g->id, 'ho_ten' => $g->ho_ten, 'don_gia_gio' => $g->don_gia_gio]));
        </script>
        <script src="{{ asset('js/pages/chamcong.js') }}"></script>
    @endpush
@endsection
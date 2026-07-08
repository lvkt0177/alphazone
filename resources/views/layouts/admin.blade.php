<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - AlphaZone Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>

<body>

    <div @class(['app']) id="appRoot">

        {{-- SIDEBAR --}}
        @include('partials._sidebar')

        <div @class(['main'])>
            {{-- TOPBAR --}}
            @include('partials._topbar')

            <div @class(['page'])>
                @yield('content')
            </div>
        </div>
    </div>

    {{-- MODALS DÙNG CHUNG --}}
    @include('partials.modals._student')
    @include('partials.modals._tuition')
    @include('partials.modals._trial')
    @include('partials.modals._branch')
    @include('partials.modals._teacher')
    @include('partials.modals._confirm')

    {{-- TOAST --}}
    @include('partials._toast')

    <script src="{{ asset('js/common.js') }}"></script>
    @stack('scripts')
</body>

</html>

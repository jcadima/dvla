<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link href="{{ asset('favicon.ico') }}" rel="icon">
    
    <title>Login - DVLA</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @livewireStyles
    @yield('styles')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="dvla-login">
    <div id="app">
        @yield('content')
    </div>

@livewireScripts
@stack('scripts')
</body>
</html>

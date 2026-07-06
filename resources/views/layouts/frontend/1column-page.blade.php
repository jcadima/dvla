<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="description" content="{{ $meta_description ?? '' }}">

    <!-- Favicon -->
    <link href="{{ asset('favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">   -->

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Libraries Stylesheet -->
    <!-- <link href="{{ asset('css/animate/animate.min.css') }}" rel="stylesheet">  -->
    <!-- <link href="{{ asset('css/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    @livewireStyles
    @yield('styles')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    @if( $settings->google_ga)
    <!-- Google Analytics -->
    <!-- End Google Analytics -->
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <!-- views/layouts/frontend/1column-page.blade.php -->


    <!-- Navbar Start -->
    <x-front.navbar :settings="$settings" />
    <!-- Navbar End -->


    <!-- Content Start -->
    <div class="wrapper">
        {{ $slot }}
    </div>
    <!-- Content End -->


    <!-- Footer Start -->
    <x-front.footer :socialMediaLinks="$socialMediaLinks" :settings="$settings" />
    <!-- Footer End -->


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

</body>
@livewireScripts
@yield('scripts')

</html>

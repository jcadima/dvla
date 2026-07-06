<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <!--
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.5/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @livewireStyles
    @yield('styles')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <div id="app">

        <!--  SIDEBAR  -->
        <x-admin.sidebar />


        <div id="main" class='layout-navbar'>

            <!--  HEADER TOP BAR  -->
            <x-admin.topbar />


            <div id="main-content">

                <div class="page-heading">


                    <!--  PAGE BREADCRUMBS  -->
                    <div class="row">
                        <div class="col-12">
                            <nav aria-label="breadcrumb" class="breadcrumb-header">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ ($title == 'Dashboard') ? 'Index' : $title }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <!--  CONTENT SECTION -->
                    <section class="section">

                        {{ $slot }}

                    </section>

                </div>

                <!--  FOOTER  -->
                <x-admin.footer />

            </div>
        </div>
    </div>


    @livewireScripts
    @livewireChartsScripts

    <script src="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.5/perfect-scrollbar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Custom toastr
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right', // Position of the toast container
            preventDuplicates: true, // Prevent duplicate notifications
            showDuration: 200, // Duration of show animation
            hideDuration: 1000, // Duration of hide animation
            timeOut: 5000, // Time until it automatically hidess
            extendedTimeOut: 1000, // Time to close after a user hovers over
            tapToDismiss: false // Click on toasts to dismiss them
        };

        // Check if the session has a success message
        @if(Session::has('notification'))
            const notification = @json(Session::get('notification'));

            toastr[notification.type](notification.message);
        @endif

        // Event toastr
        Livewire.on('notification', (data) => {
            toastr[data[0].type](data[0].message);
        });
    </script>

    @stack('scripts')

</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }} — Down for Maintenance</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="{{ asset('favicon.ico') }}" rel="icon">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0a0e17;
            color: #e4e7eb;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            text-align: center;
        }

        .maintenance-icon {
            font-size: 3rem;
            color: #dc3545;
            margin-bottom: 1.5rem;
        }

        h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        p {
            color: #9ca3af;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="maintenance-icon">
            <i class="fa-solid fa-screwdriver-wrench"></i>
        </div>
        <h1>{{ config('app.name') }} is down for maintenance</h1>
        <p>We'll be back shortly. Please check again soon.</p>
    </div>
</body>

</html>

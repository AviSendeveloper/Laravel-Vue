<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Image and background -->
    <link href="{{ asset('assets/img/avatars') }}" />
    <link href="{{ asset('assets/img/backgrounds') }}" />
    <link href="{{ asset('assets/img/elements') }}" />
    <link href="{{ asset('assets/img/icons') }}" />
    <link href="{{ asset('assets/img/illustrations') }}" />
    <link href="{{ asset('assets/img/layouts') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="css/app.css">
</head>

<body>
    <div id="app">
        <main-app></main-app>
    </div>
</body>

<script src="{{ mix('js/app.js') }}"></script>

{{-- ivuew --}}
<link rel="stylesheet" type="text/css" href="https://unpkg.com/view-ui-plus/dist/styles/viewuiplus.css">
{{-- <script type="text/javascript" src="https://unpkg.com/vue@next"></script> --}}
{{-- <script type="text/javascript" src="https://unpkg.com/view-ui-plus"></script> --}}

</html>

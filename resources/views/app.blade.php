<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url('images/logo_color.png') }}" />
    <!-- Styles -->

    <link href="{{ url('/css/rte.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ url('/css/app.css') }}" rel="stylesheet" type="text/css">
    <!-- Polyfills für IE
        <script src='https://cdn.polyfill.io/v2/polyfill.min.js'></script>-->
    <link rel="stylesheet" href="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/foundicons/3.0.0/foundation-icons.css' rel='stylesheet' type='text/css'>
</head>
<body>
    <div class="top-bar">
        <div class="row">
            <div class="top-bar-left">
                <ul class="dropdown menu" data-dropdown-menu>
                    <li class="menu-text">Yeti Store</li>
                    <li class="has-submenu">
                        <a href="#">One</a>
                        <ul class="submenu menu vertical" data-submenu>
                            <li><a href="#">One</a></li>
                            <li><a href="#">Two</a></li>
                            <li><a href="#">Three</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Two</a></li>
                    <li><a href="#">Three</a></li>
                </ul>
            </div>
            <div class="top-bar-right">
                <ul class="menu">
                    <li><input type="search" placeholder="Search"></li>
                    <li><button type="button" class="button">Search</button></li>
                </ul>
            </div>
        </div>
    </div>

    <br>

    @yield('content')

    @include('laragento.footer')

    <script>
        window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
    </script>

    <script src="{{ url('/js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.js"></script>
    <script>
        $(document).foundation();
    </script>
    <script src="{{ asset('js/products.js') }}"></script>
</body>
</html>
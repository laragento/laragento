<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Module Admin</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    {{-- Laravel Mix - CSS File --}}
    {{-- <link rel="stylesheet" href="{{ mix('css/admin.css') }}"> --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield('css')
    @yield('topscripts')

</head>
<body>
<div class="site-container">
    <header>

    </header>
    <main>
        @if(Auth::guard('admins')->check())
            <form style="display:none" id="admin-logout-form" action="{{route('admin.logout')}}" method="post">
                @csrf
            </form>
            <nav>
                <input type="checkbox" id="toggle-nav" name="toggle-nav">
                <label for="toggle-nav" id="nav-toggler"><span>Menu</span></label>
                <ul class="first-level">
                    <li><span>Logo</span></li>
                    @if(config('admin.modules.laragentocms') === 1)
                        @include('laragentocms::partials.nav')
                    @endif
                    <li><span onclick="submitLogoutForm()" class="pseudo-link">Logout</span></li>
                </ul>
            </nav>
        @endif
        <section class="content">
            @yield('content')
        </section>
    </main>
    <footer>
        Footertext
    </footer>
</div>

{{-- Laravel Mix - JS File --}}
{{-- <script src="{{ mix('js/admin.js') }}"></script> --}}
<script src="{{ mix('js/app.js') }}"></script>
@if(Auth::check('admins'))
    <script>
        let submitLogoutForm = function () {
            let logoutForm = document.querySelector('#admin-logout-form');
            logoutForm.submit();
        }
    </script>
@endif
@yield('scripts')
</body>
</html>

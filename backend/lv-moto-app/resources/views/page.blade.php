<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('header')
    <body class="antialiased">
        @include('nav')
        <div class="container">
            @yield('content')
        </div>
        @include('footer')
    </body>
</html>
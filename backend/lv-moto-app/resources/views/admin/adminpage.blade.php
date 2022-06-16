<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('admin.header')
    <body class="antialiased">
        @include('admin.navbar')
        <div class="adm-container">
            @yield('content')
        </div>
    </body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Authentication</title>

        @vite(['resources/css/auth.css','resources/css/dist/css/lib/bootstrap.min.css','resources/css/dist/css/swipe.min.css', 'resources/css/dist/img/favicon.png', 'resources/js/js/vendor/popper.min.js', 'resources/js/js/vendor/bootstrap.min.js'])

        @livewireStyles
    </head>
    <body>
        {{ $slot }}

        @livewireScripts

        <script src="dist/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script>window.jQuery || document.write('<script src="dist/js/vendor/jquery-slim.min.js"><\/script>')</script>
        <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    </body>
</html>

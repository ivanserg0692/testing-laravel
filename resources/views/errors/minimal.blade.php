<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>
        @vite('resources/sass/app.scss')

    </head>
    <body>
    <br>
    <br>
    <x-centred-page>
        <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">
            @yield('code')
        </div>

        <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
            @yield('message')
        </div>
    </x-centred-page>
    </body>
</html>

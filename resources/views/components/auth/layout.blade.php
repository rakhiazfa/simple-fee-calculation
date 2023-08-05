<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite('resources/css/app.css')

    <title>{{ $title }}</title>
</head>

<body>

    <div class="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>

    <div class="admin-wrapper">

        <div class="overlay"></div>

        <x-auth.sidebar :user="$user"></x-auth.sidebar>

        <div class="content">

            <x-auth.topbar :user="$user" :title="$originTitle"></x-auth.topbar>

            <main class="main">

                {{ $slot }}

            </main>

        </div>

    </div>

    @vite('resources/js/app.js')

</body>

</html>

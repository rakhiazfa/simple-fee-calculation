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

    {{ $slot }}

    @vite('resources/js/app.js')

</body>

</html>

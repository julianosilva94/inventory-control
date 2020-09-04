<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Controle de Estoque</title>

    <!-- Fonts -->
    {{--        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">--}}

    <link rel="stylesheet" href="/css/main.css">
    <script src="/js/app.js" defer></script>
</head>
<body>
    <div id="app" class="w-full h-full min-h-screen pb-20 bg-gray-100">
        @yield('container')
    </div>
</body>
</html>

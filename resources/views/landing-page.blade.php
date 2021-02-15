<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <title>{{ config('app.name') }} - Play Microscope Online</title>
</head>
<body class="h-full page-header">
    <div class="flex items-center justify-center h-full">
        <div class="w-1/3">
            <div>
                <h1 class="text-3xl md:text-5xl font-bold tracking-wider text-gray-100 pb-6 text-center">
                    Play <a href="http://www.lamemage.com/microscope/" rel="noreferrer noopener" alt="Microscope">Microscope</a> online
                </h1>
                <p class="text-gray-200 mb-4">
                    Utgar's Chronicles is a website that enables you to play Microscope with your friends all over the world.<br>
                    Completely for free. I just really like this game!
                </p>
            </div>
            <div class="flex justify-center">
                <div class="w-2/3">
                    <a href="{{ route('login') }}" class="float-left p-4 rounded text-gray-100 bg-gray-700 hover:bg-gray-100 hover:text-red-600">Login</a>
                    <a href="{{ route('register') }}" class="float-right p-4 rounded text-gray-700 bg-gray-100 hover:bg-gray-700 hover:text-red-600">Register</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

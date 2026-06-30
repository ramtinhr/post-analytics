<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <title>پنل مدیریت</title>

</head>


<body class="min-h-screen bg-slate-950 flex items-center justify-center">


<div class="absolute inset-0">

    <div class="absolute top-20 right-20 w-72 h-72 bg-blue-600/30 rounded-full blur-3xl"></div>

    <div class="absolute bottom-20 left-20 w-72 h-72 bg-purple-600/30 rounded-full blur-3xl"></div>

</div>



<div class="relative w-full max-w-md px-5">


    {{ $slot ?? '' }}

    @yield('content')


</div>


</body>

</html>

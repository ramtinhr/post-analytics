<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>

<meta charset="UTF-8">

@vite([
'resources/css/app.css',
'resources/js/app.js'
])

</head>


<body class="bg-slate-100">


<div class="flex min-h-screen">


{{-- sidebar --}}
<aside class="w-64 bg-slate-900 text-white p-5">


<h1 class="text-2xl font-bold mb-10">
Post Analytics
</h1>



<nav class="space-y-3">


<a href="/dashboard"
class="block p-3 rounded-xl hover:bg-slate-800">

داشبورد

</a>


<a href="/posts"
class="block p-3 rounded-xl hover:bg-slate-800">

پست‌ها

</a>



<a href="/analytics"
class="block p-3 rounded-xl hover:bg-slate-800">

تحلیل‌ها

</a>


<form method="POST" action="/logout">

@csrf

<button
class="w-full text-right p-3 rounded-xl hover:bg-red-900">

خروج

</button>

</form>


</nav>


</aside>




<main class="flex-1 p-8">


@yield('content')


</main>



</div>


</body>
</html>

@stack('scripts')

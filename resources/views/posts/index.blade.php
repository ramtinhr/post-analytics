@extends('layouts.app')

@section('content')


<div class="flex justify-between items-center mb-8">

<div>
<h1 class="text-3xl font-black text-slate-900">
پست‌ها
</h1>

<p class="text-slate-500 mt-2">
مدیریت محتوا و تحلیل بازدید
</p>

</div>


<a href="{{ route('posts.create') }}"
class="bg-indigo-600 text-white px-5 py-3 rounded-2xl shadow-lg">

+ ایجاد پست

</a>

</div>



<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">


@foreach($posts as $post)


<div class="bg-white rounded-3xl shadow-sm border p-5">


<div class="flex gap-5">


@if($post->image)

<img
src="{{ asset('storage/'.$post->image) }}"
class="w-32 h-32 rounded-2xl object-cover"
/>

@else

<div
class="w-32 h-32 rounded-2xl bg-slate-100 flex items-center justify-center text-4xl">

📝

</div>

@endif




<div class="flex-1">


<h2 class="text-xl font-bold">

{{ $post->title }}

</h2>


<p class="text-slate-500 text-sm mt-2 line-clamp-3">

{{ $post->content }}

</p>


<div class="flex gap-3 mt-4">


<span
class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">

👁 {{ $post->views_count }}

</span>



<span
class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

👤
{{ $post->views()
->distinct('user_id')
->count('user_id') }}

</span>


</div>



</div>


</div>



<div class="border-t mt-5 pt-4 flex justify-between items-center">


<div class="text-sm text-slate-500">

{{ $post->user->name }}

<br>

{{ $post->created_at->format('Y/m/d') }}

</div>



<div class="flex gap-3">


<a
href="#"
class="px-4 py-2 bg-slate-100 rounded-xl">

ویرایش

</a>



<form method="POST"
action="{{ route('posts.destroy',$post) }}">

@csrf
@method('DELETE')


<button
class="px-4 py-2 bg-red-100 text-red-600 rounded-xl">

حذف

</button>


</form>


</div>


</div>



</div>


@endforeach


</div>



<div class="mt-8">

{{ $posts->links() }}

</div>


@endsection

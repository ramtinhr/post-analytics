@extends('layouts.app')


@section('content')


<h1 class="text-3xl font-black mb-8">
ویرایش پست
</h1>



<form
method="POST"
action="{{ route('posts.update',$post) }}"
enctype="multipart/form-data"
class="bg-white rounded-3xl p-8 space-y-5">


@csrf
@method('PUT')



<input
name="title"
value="{{ $post->title }}"
class="w-full border rounded-xl p-3"
/>



<textarea
name="content"
class="w-full border rounded-xl p-3"
>{{ $post->content }}</textarea>



<input
type="file"
name="image"
>



<button
class="bg-indigo-600 text-white px-8 py-3 rounded-xl">

ذخیره تغییرات

</button>


</form>


@endsection

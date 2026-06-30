@extends('layouts.app')


@section('content')


<div class="max-w-3xl">


<h1 class="text-3xl font-black mb-8">
ایجاد پست جدید
</h1>



<form
method="POST"
action="{{ route('posts.store') }}"
enctype="multipart/form-data"
class="bg-white rounded-3xl shadow p-8 space-y-5">


@csrf



<div>

<label class="text-sm">
عنوان
</label>


<input
name="title"
class="w-full mt-2 rounded-xl border p-3"
>

</div>




<div>

<label>
محتوا
</label>


<textarea
name="content"
rows="8"
class="w-full mt-2 rounded-xl border p-3"
></textarea>


</div>



<div>

<label>
تصویر شاخص
</label>


<input
type="file"
name="image"
class="mt-2"
>


</div>




<button
class="bg-indigo-600 text-white px-8 py-3 rounded-xl">

ذخیره

</button>



</form>


</div>


@endsection

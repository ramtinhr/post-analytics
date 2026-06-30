@extends('layouts.app')

@section('content')

<div class="mb-8">
    <h1 class="text-3xl font-black text-slate-900">
        تحلیل بازدید محتوا
    </h1>

    <p class="text-slate-500 mt-2">
        آمار بازدید پست‌ها و کاربران
    </p>
</div>


<form method="GET"
      class="bg-white rounded-3xl shadow p-6 mb-8 flex gap-4 items-end">

    <div>
        <label class="text-sm text-slate-500">
            از تاریخ
        </label>

        <input
            type="date"
            name="from"
            value="{{ $from }}"
            class="mt-2 border rounded-xl p-3">
    </div>


    <div>
        <label class="text-sm text-slate-500">
            تا تاریخ
        </label>

        <input
            type="date"
            name="to"
            value="{{ $to }}"
            class="mt-2 border rounded-xl p-3">
    </div>


    <button
        class="bg-indigo-600 text-white rounded-xl px-8 py-3">

        فیلتر

    </button>

</form>



<div class="grid md:grid-cols-3 gap-6 mb-8">


<div class="bg-white rounded-3xl shadow p-6">

<p class="text-slate-500">
کل بازدید
</p>

<div class="text-4xl font-black mt-3">
{{ $daily->sum('total_views') }}
</div>

</div>



<div class="bg-white rounded-3xl shadow p-6">

<p class="text-slate-500">
کاربر یکتا
</p>

<div class="text-4xl font-black mt-3">
{{ $daily->sum('unique_users') }}
</div>

</div>



<div class="bg-white rounded-3xl shadow p-6">

<p class="text-slate-500">
روزهای تحلیل
</p>

<div class="text-4xl font-black mt-3">
{{ $daily->count() }}
</div>

</div>


</div>





<div class="bg-white rounded-3xl shadow p-8">


<h2 class="font-bold text-xl mb-6">
نمودار بازدید روزانه
</h2>


<div class="h-96">

<canvas id="viewsChart"></canvas>

</div>


</div>





<div class="bg-white rounded-3xl shadow p-8 mt-8">


<h2 class="font-bold text-xl mb-6">
پست‌های پربازدید
</h2>


<div class="space-y-4">


@foreach($topPosts as $i=>$post)


<div class="flex justify-between items-center bg-slate-50 p-5 rounded-2xl">


<div class="flex gap-4 items-center">


<div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center">

{{ $i+1 }}

</div>


<div>

<div class="font-bold">

{{ $post->title }}

</div>


<div class="text-sm text-slate-500">

{{ $post->created_at->format('Y-m-d') }}

</div>


</div>


</div>



<div class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full">

{{ $post->views_count }}

بازدید

</div>


</div>


@endforeach


</div>


</div>



@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

new Chart(
document.getElementById('viewsChart'),
{

type:'line',

data:{

labels:@json($daily->pluck('date')),

datasets:[{

label:'بازدید',

data:@json($daily->pluck('total_views')),

borderWidth:3,

tension:.4

}]

},

options:{

responsive:true,

maintainAspectRatio:false

}

});


</script>

@endpush


@endsection

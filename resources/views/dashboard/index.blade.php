@extends('layouts.app')


@section('content')


<h1 class="text-3xl font-bold text-slate-900 mb-8">
    داشبورد تحلیل
</h1>



<div class="grid grid-cols-4 gap-5">


<x-stat-card
    title="کل بازدید"
    :value="$stats['total_views']"
/>


<x-stat-card
    title="کاربران یکتا"
    :value="$stats['unique_users']"
/>


<x-stat-card
    title="میانگین روزانه"
    :value="$stats['average_daily_users']"
/>


<x-stat-card
    title="تعداد پست"
    :value="$stats['posts']"
/>


</div>



<div class="mt-8 bg-white rounded-2xl shadow p-6 border">


<h2 class="font-bold text-lg mb-5">
    نمودار بازدید
</h2>


<canvas id="viewsChart"></canvas>


</div>




<div class="mt-8 bg-white rounded-2xl shadow p-6 border">


<h2 class="font-bold text-lg mb-5">
پربازدیدترین پست‌ها
</h2>



<table class="w-full">


<thead>

<tr class="text-right text-slate-500">

<th class="p-3">
رتبه
</th>

<th class="p-3">
عنوان
</th>

<th class="p-3">
بازدید
</th>

<th class="p-3">
کاربر یکتا
</th>

</tr>

</thead>



<tbody>


@foreach($topPosts as $post)


<tr class="border-t">


<td class="p-3">
#{{ $post['rank'] }}
</td>


<td class="p-3 font-medium">
{{ $post['title'] }}
</td>


<td class="p-3">
{{ $post['total_views'] }}
</td>


<td class="p-3">
{{ $post['unique_users'] }}
</td>


</tr>


@endforeach


</tbody>


</table>


</div>




@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>


new Chart(
document.getElementById('viewsChart'),
{

type:'line',

data:{

labels:@json($chart['dates']),

datasets:[{

label:'بازدید',

data:@json($chart['views']),

borderWidth:2

}]

},


options:{

responsive:true

}


});

</script>

@endpush


@endsection

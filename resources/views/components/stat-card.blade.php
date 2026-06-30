@props([
    'title',
    'value',
    'icon' => null
])


<div class="bg-white rounded-2xl shadow p-6 border border-slate-200">

    <div class="flex justify-between items-center">


        <div>

            <p class="text-sm text-slate-500">
                {{ $title }}
            </p>


            <h2 class="text-3xl font-bold text-slate-900 mt-2">
                {{ $value }}
            </h2>

        </div>



        @if($icon)

            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">

                {{ $icon }}

            </div>

        @endif


    </div>

</div>

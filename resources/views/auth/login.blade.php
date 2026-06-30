@extends('layouts.guest')


@section('content')

<div class="bg-white/95 backdrop-blur rounded-3xl shadow-2xl p-8 border border-slate-200">


    <div class="text-center mb-8">


        <div class="mx-auto w-16 h-16 rounded-2xl bg-slate-900 flex items-center justify-center mb-4 shadow-lg">

            <span class="text-white text-2xl font-bold">
                PA
            </span>

        </div>


        <h1 class="text-2xl font-bold text-slate-900">
            ورود به پنل مدیریت
        </h1>


        <p class="text-slate-500 mt-2">
            تحلیل بازدید محتوا
        </p>


    </div>



    @if($errors->any())

        <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded-xl mb-5 text-sm">
            {{ $errors->first() }}
        </div>

    @endif




    <form method="POST" action="{{ route('login') }}" class="space-y-5">

        @csrf



        <div>


            <label class="block text-sm font-medium text-slate-700 mb-2">
                ایمیل
            </label>


            <input

                type="email"

                name="email"

                value="{{ old('email') }}"

                class="
                w-full
                rounded-xl
                border
                border-slate-300
                bg-white
                px-4
                py-3
                text-slate-800
                outline-none
                transition

                focus:border-blue-500
                focus:ring-4
                focus:ring-blue-100

                "

                placeholder="admin@example.com"

            >


        </div>




        <div>


            <label class="block text-sm font-medium text-slate-700 mb-2">
                رمز عبور
            </label>


            <input

                type="password"

                name="password"

                class="
                w-full
                rounded-xl
                border
                border-slate-300
                bg-white
                px-4
                py-3
                text-slate-800
                outline-none
                transition

                focus:border-blue-500
                focus:ring-4
                focus:ring-blue-100

                "

                placeholder="••••••••"

            >


        </div>




        <div class="flex items-center justify-between">


            <label class="flex items-center gap-2 text-sm text-slate-600">

                <input
                    type="checkbox"
                    name="remember"
                    class="rounded border-slate-300 text-blue-600"
                >

                مرا به خاطر بسپار

            </label>


        </div>




        <button

            type="submit"

            class="
            w-full
            bg-slate-900
            hover:bg-slate-800
            text-white
            rounded-xl
            py-3
            font-semibold
            shadow-lg
            transition
            active:scale-[0.98]
            "

        >

            ورود به داشبورد

        </button>



    </form>


</div>

@endsection

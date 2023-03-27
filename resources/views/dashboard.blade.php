<x-app-layout>
    <x-slot name="header">

{{--         <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2> --}}

{{--  <a class="underline text-sm text-gray-600 dark:text-red-400 hover:text-blue-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route(config('chatify.routes.prefix')) }}">
                {{ __("chat app") }}
            </a> --}}
                     <a class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded" href="{{ route(config('chatify.routes.prefix')) }}">
                 Chat App
                    </a>


    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

            </div>
        </div>
    </div>
</x-app-layout>

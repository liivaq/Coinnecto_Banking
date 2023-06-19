<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="p-6 text-gray-900">
        <div x-data="{ count: 0 }">
            <button x-on:click="count++">Increment</button>

            <span x-text="count"></span>
        </div>
    </div>


</x-app-layout>

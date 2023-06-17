<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crypto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach($cryptoCollection as $crypto)
                    <div class="border-b border-solid border-gray-200 mx-10 my-5">
                        <ul class="flex gap-x-4">
                            <li>{{$crypto->getName()}}</li>
                            <li>{{$crypto->getSymbol()}}</li>
                            <li>{{$crypto->getPrice()}}</li>
                        </ul>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</x-app-layout>

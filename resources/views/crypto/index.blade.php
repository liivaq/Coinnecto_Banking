<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crypto') }}
        </h2>
    </x-slot>

    <div class="bg-white rounded-lg">
        <div class="flex flex-wrap text-xl font-bold border-b border-gray-300">
            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-4">
                Name
            </div>
            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-4">
                Symbol
            </div>
            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-4">
                Price (€)
            </div>
            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-4">
                Change 1h (%)
            </div>
            <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-4">
                Change 24h (%)
            </div>
        </div>


        <div class="flex flex-wrap">
            @foreach($cryptoCollection as $crypto)
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-4">
                    {{$crypto->getName()}}
                </div>
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-4">
                    {{$crypto->getSymbol()}}
                </div>
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-4">
                    {{number_format($crypto->getPrice(),4)}}
                </div>

                @if($crypto->getPercentChange1h() > 0)
                    <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-4 text-green-600">
                        + {{number_format($crypto->getPercentChange1h(), 4)}}
                    </div>
                @endif

                @if($crypto->getPercentChange1h() < 0)
                    <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-4 text-red-600">
                        {{number_format($crypto->getPercentChange1h(), 4)}}
                    </div>
                @endif

                @if($crypto->getPercentChange24h() > 0)
                    <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-4 text-green-600">
                        + {{number_format($crypto->getPercentChange24h(),4)}}
                    </div>
                @endif

                @if($crypto->getPercentChange24h() < 0)
                    <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 p-4 text-red-600">
                        {{number_format($crypto->getPercentChange24h(), 4)}}
                    </div>
                @endif
            @endforeach
        </div>
    </div>

</x-app-layout>

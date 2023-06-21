<x-app-layout>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 ">
        @foreach($cryptos as $crypto)
        <div class="relative bg-white p-4 rounded-xl flex flex-col ">
                <img src="{{$crypto->getIconUrl()}}" alt="{{$crypto->getSymbol()}}" class="absolute top-4 right-4 w-12">

            <div>
                <h4 class="text-xl font-bold">{{$crypto->getSymbol()}}</h4>
                <p class="text-gray-500">You own: {{$amounts[$crypto->getId()]}}</p>
                <p class="text-gray-500">Current Price: {{$crypto->getPrice()}}</p>

                @if($crypto->getPercentChange1h() > 0)
                <p class="text-green-500">Change (1h): {{$crypto->getPercentChange1h()}}</p>
                @endif
                @if($crypto->getPercentChange1h() < 0)
                    <p class="text-red-500">Change (1h): {{$crypto->getPercentChange1h()}}</p>
                @endif
                @if($crypto->getPercentChange24h() > 0)
                    <p class="text-green-500">Change (1h): {{$crypto->getPercentChange24h()}}</p>
                @endif
                @if($crypto->getPercentChange24h() < 0)
                    <p class="text-red-500">Change (1h): {{$crypto->getPercentChange24h()}}</p>
                @endif
            </div>
            <div class="mt-4 flex justify-center">
                <a href="{{ url('crypto/'.$crypto->getId()) }}"><x-secondary-button>Trade</x-secondary-button></a>
            </div>
        </div>
        @endforeach
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        Crypto Portfolio
    </x-slot>

    @if ($message = Session::get('success'))
        <x-flash>{{$message}}</x-flash>
    @endif

    @if(!$cryptos)
        <div class="mt-4 mb-6 bg-white p-5 rounded-xl">
            <div>
                <h1 class="text-2xl font-bold">You have no Cryptos!</h1>
                <p class="mt-4 text-md text-gray-600">
                    Head to the crypto market to explore the latest market change and trade cryptos!
                </p>
            </div>

            <div class="mt-4">
                <a href="{{ route('crypto.index') }}">
                    <x-primary-button>Explore Crypto market</x-primary-button>
                </a>
            </div>

        </div>

    @else
        <div class="mt-2 mb-6 bg-white p-5 rounded-xl">
            <div>
                <h1 class="text-2xl font-bold">Your crypto portfolio</h1>
            </div>

            <div class="mt-6">
                <div class="mt-1 text-md text-gray-600">
                    See all of your cryptos in one place. Explore the latest market change and see an overview of recent
                    crypto
                    transactions.
                </div>
                <div class="flex gap-x-6">
                    <div class="mt-4">
                        <a href="{{ route('crypto.index') }}">
                            <x-primary-button>Explore Crypto market</x-primary-button>
                        </a>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('crypto.transactions') }}">
                            <x-primary-button>Your Crypto Transaction history</x-primary-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 ">
            @foreach($cryptos as $crypto)
                <div class="relative bg-white p-4 rounded-xl flex flex-col ">
                    <img src="{{$crypto->getIconUrl()}}" alt="{{$crypto->getSymbol()}}"
                         class="absolute top-4 right-4 w-12">

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
                            <p class="text-green-500">Change (24h): {{$crypto->getPercentChange24h()}}</p>
                        @endif
                        @if($crypto->getPercentChange24h() < 0)
                            <p class="text-red-500">Change (24h): {{$crypto->getPercentChange24h()}}</p>
                        @endif
                    </div>
                    <div class="mt-4 flex justify-center">
                        <a href="{{ url('crypto/'.$crypto->getId()) }}">
                            <x-secondary-button>Trade</x-secondary-button>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
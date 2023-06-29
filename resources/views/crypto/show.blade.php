<x-app-layout>
    <x-slot name="header">
        <x-slot name="header">
            Trade {{$crypto->name}}
        </x-slot>
    </x-slot>

    <div id="result" class="pb-4">
        <div class="bg-white shadow sm:rounded-lg">
            <div class="flex items-center p-4 sm:p-8">
                <div class="flex-none pr-4">
                    <img class="w-16 h-auto" src="{{$crypto->iconUrl}}" alt="{{$crypto->name}}">
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold">{{$crypto->name}}</h2>
                    <p class="text-gray-500">{{$crypto->symbol}}</p>
                </div>

                <div class="flex-1">
                    <p class="font-bold">You Own:</p>
                    <p class="user-crypto-amount">{{$userCrypto->amount ?? 0}}</p>
                </div>

                <div class="flex-1">
                    <p class="font-bold">Price  <span class="currency">EUR</span></p>
                    <p class="crypto-price">{{$crypto->price}}</p>
                </div>
                <div class="flex-1">
                    <p class="font-bold">Change 1h (%)</p>
                    @if($crypto->percentChange1h > 0)
                        <p class="text-green-500">{{$crypto->percentChange1h}}</p>
                    @endif
                    @if($crypto->percentChange1h < 0)
                        <p class="text-red-500">{{$crypto->percentChange1h}}</p>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="font-bold">Change 24h (%)</p>
                    @if($crypto->percentChange24h > 0)
                        <p class="text-green-500">{{$crypto->percentChange24h}}</p>
                    @endif
                    @if($crypto->percentChange24h < 0)
                        <p class="text-red-500">{{$crypto->percentChange24h}}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ selectedOption: '', cryptoId: '', price: {{$crypto->price}} }" x-init="cryptoId = '{{ $crypto->id }}'"  class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            @if(count($accounts) === 0)
                <div class="flex-col">
                    <div class="text-xl font-semibold">Open an investment account to
                        trade {{$crypto->name}}</div>
                    <div class="mt-4">
                        <a href="{{ route('accounts.create') }}">
                            <x-secondary-button>Create an account</x-secondary-button>
                        </a>
                    </div>
                </div>
            @else
                <h2 class="text-lg font-medium text-gray-900">
                    Trade {{$crypto->name}}
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Buy and sell {{$crypto->name}}
                </p>
                <form method="post" action="{{ route('crypto.buy') }}" class="mt-6 space-y-6" autocomplete="off">
                    @csrf
                    <div >
                        <x-input-label for="account" value="Choose your investment account"/>
                        <x-selection-input id="account" name="account" class="mt-1 block w-full"
                                           selected="{{ old('account') }}" x-on:change="handleSelection" x-model="selectedOption"
                                           x-data="{ oldOption: '{{ old('account') }}' }">
                            @foreach($accounts as $account)
                                <option value="{{$account->number}}" :selected="oldOption === '{{$account->number}}' ? true : false">
                                    {{$account->name}} {{$account->number}} ({{number_format($account->balance, 2)}}
                                    )
                                </option>
                            @endforeach
                        </x-selection-input>
                    </div>

                    <div x-data="{ amount: {{ old('amount', 0) }} }">
                        <input x-model="cryptoId" type="hidden" id="crypto_coin" name="crypto_coin" value="{{ $crypto->id }}"/>

                        <x-input-label for="amount" value="Amount"/>
                        <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full"
                                      :value="old('amount')" x-model="amount"/>

                        <input type="hidden" id="crypto-price" name="price" value="{{$crypto->price}}">

                        @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror

                        <div class="mt-6">
                            <p class="text-s text-gray-700">Total price: <span class="total-price" x-text="amount * price"></span>
                                <span class="currency">EUR</span></p>
                        </div>
                    </div>

                    <div>
                        <div class="flex gap-x-2">
                            <x-input-label for="one_time_password" value="Verify Transaction"/>
                            <x-tooltip>
                                Use an authenticator app - enter the code below.
                                See more information on your
                                <a class="text-decoration-line: underline" href="{{ route('profile.edit') }}">Profile
                                    page</a>
                            </x-tooltip>
                        </div>
                        <x-text-input id="one_time_password" name="one_time_password" type="text"
                                      class="mt-1 block w-full"
                                      placeholder="1234"/>
                        @error('one_time_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-cloak x-data="{ hasCryptos: true }" x-init="hasCryptos = {{ isset($userCrypto->amount) && $userCrypto->amount > 0  ? 'true' : 'false' }}">
                        <x-primary-button name="type" value="buy">Buy</x-primary-button>
                        <x-primary-button x-bind:disabled="!hasCryptos"
                                          x-bind:class="{ 'opacity-50 cursor-not-allowed': !hasCryptos }"
                                          name="type" value="sell" formaction="{{ route('crypto.sell') }} "
                        >
                            Sell
                        </x-primary-button>
                        <a href="{{ route('crypto.index') }}">
                            <x-secondary-button>Cancel</x-secondary-button>
                        </a>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <script>
        function handleSelection() {
            if (this.selectedOption) {
                const requestData = {
                    account: this.selectedOption,
                    id: this.cryptoId
                };

                fetch('/crypto/values', {
                    method: 'POST',
                    body: JSON.stringify(requestData),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Fetched data:', data);

                        const amountElements = document.querySelectorAll('.user-crypto-amount');
                        amountElements.forEach(element => {
                            element.textContent = data.amount;
                        });

                        const priceElements = document.querySelectorAll('.crypto-price');
                        priceElements.forEach(element => {
                            element.textContent = data.crypto.price;
                        });

                        this.price = data.crypto.price;

                        const currencyElements = document.querySelectorAll('.currency');
                        currencyElements.forEach(element => {
                            element.textContent = data.currency;
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        }
    </script>
</x-app-layout>

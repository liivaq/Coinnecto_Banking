<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crypto') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="flex">
                <!-- Column titles -->
                <div class="flex-1 font-bold">Name</div>
                <div class="flex-1 font-bold">Symbol</div>
                <div class="flex-1 font-bold">Price (€)</div>
                <div class="flex-1 font-bold">Change 1h (%)</div>
                <div class="flex-1 font-bold">Change 24h (%)</div>
            </div>

            <div class="flex">
                <!-- Values -->
                <div class="flex-1">{{$crypto->getName()}}</div>
                <div class="flex-1">{{$crypto->getSymbol()}}</div>
                <div class="flex-1">{{$crypto->getPrice()}}</div>

                @if($crypto->getPercentChange1h() > 0)
                    <div class="flex-1 text-green-500">{{$crypto->getPercentChange1h()}}</div>
                @endif

                @if($crypto->getPercentChange1h() < 0)
                    <div class="flex-1 text-red-500">{{$crypto->getPercentChange1h()}}</div>
                @endif

                @if($crypto->getPercentChange24h() > 0)
                    <div class="flex-1 text-green-500">{{$crypto->getPercentChange24h()}}</div>
                @endif

                @if($crypto->getPercentChange24h() < 0)
                    <div class="flex-1 text-red-500">{{$crypto->getPercentChange24h()}}</div>
                @endif
            </div>


        </div>


        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @if(count($accounts) === 0)
                    <div class="flex-col">
                        <div class="text-xl font-semibold">Open an investment account to trade {{$crypto->getName()}}</div>
                        <div class="mt-4">
                            <a href="{{ route('accounts.create') }}">
                                <x-secondary-button>Create an account</x-secondary-button>
                            </a>
                        </div>
                    </div>
                @else
                    <h2 class="text-lg font-medium text-gray-900">
                        Trade {{$crypto->getName()}}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Buy and sell your {{$crypto->getName()}}
                    </p>
                    <form method="post" action="{{--{{ route('transactions') }}--}}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="account_from" value="Choose your investment account"/>
                            <x-selection-input id="account_from" name="account_from" class="mt-1 block w-full"
                                               :value="old('account_from')">
                                @foreach($accounts as $account)
                                    <option value="{{$account->number}}">
                                        {{$account->name}} {{$account->number}} ({{number_format($account->balance, 2)}}
                                        )
                                    </option>
                                @endforeach
                            </x-selection-input>
                        </div>

                        <div>
                            <x-input-label for="amount" value="Amount"/>
                            <x-text-input id="amount" name="amount" type="text" class="mt-1 block w-full"
                                          placeholder="5" :value="old('amount')"/>
                            @error('amount')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex gap-x-2">
                                <x-input-label for="one_time_password" value="Verify Transaction"/>
                                <x-tooltip>
                                    Use an authenticator app - enter the code below.
                                    See more information on your
                                    <a class="text-decoration-line: underline" href="{{ route('profile.edit') }}">Profile page</a>
                                </x-tooltip>
                            </div>
                            <x-text-input id="one_time_password" name="one_time_password" type="text"
                                          class="mt-1 block w-full"
                                          placeholder="1234"/>
                            @error('one_time_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-primary-button>Buy</x-primary-button>
                            <x-primary-button>Sell</x-primary-button>
                            <a href="{{ route('crypto.index') }}">
                                <x-secondary-button>Cancel</x-secondary-button>
                            </a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        New Transaction
    </x-slot>

    @if (Session::has('transactionError'))
        <x-flash class="bg-red-200">{!! Session::get('transactionError')  !!}</x-flash>
    @endif

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <h2 class="text-lg font-medium text-gray-900">
                    Make a transaction
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Send money to any account - automatic conversion rates apply.
                </p>
                <form method="post" action="{{ route('transactions.transfer') }}" class="mt-6 space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="account_from" value="From"/>
                        <x-selection-input x-cloak id="account_from" name="account_from" class="mt-1 block w-full"
                                           :selected="old('account_from')"
                                           x-data="{ oldOption: '{{ old('account_from') }}' }">
                            @foreach($accounts as $account)
                                <option value="{{$account->number}}"
                                        x-bind:selected="oldOption === '{{$account->number}}' ? true : false">
                                    {{$account->name}} {{$account->number}}
                                    ({{number_format($account->balance, 2)}} {{$account->currency}} )
                                    / <span class="italic">{{$account->type}}</span>
                                </option>
                            @endforeach
                        </x-selection-input>
                        @error('account_from')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="account_to" value="To"/>
                        <x-text-input id="account_to" name="account_to" type="text" class="mt-1 block w-full"
                                      placeholder="Recipient's account number" :value="old('account_to')"/>
                        @error('account_to')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="amount" value="Amount"/>
                        <x-text-input id="amount" name="amount" type="text" class="mt-1 block w-full"
                                      placeholder="0.00" :value="old('amount')"/>
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

                    <div>
                        <x-primary-button>Transfer</x-primary-button>
                        <a href="{{ route('accounts.index') }}">
                            <x-secondary-button>Cancel</x-secondary-button>
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>

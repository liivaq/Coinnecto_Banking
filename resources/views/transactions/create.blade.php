<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Start a new Transaction') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <h2 class="text-lg font-medium text-gray-900">
                    Make a transaction
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Send money to any account - automatic conversion rates apply.
                </p>
                <form method="post" action="{{ route('transactions') }}" class="mt-6 space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="account_from" value="From"/>
                        <x-selection-input id="account_from" name="account_from" class="mt-1 block w-full" :value="old('account_from')">
                            @foreach($accounts as $account)
                                <option value="{{$account->number}}">
                                    {{$account->name}} {{$account->number}} ({{number_format($account->balance, 2)}})
                                </option>
                            @endforeach
                        </x-selection-input>
                    </div>

                    <div>
                        <x-input-label for="account_to" value="To"/>
                        <x-text-input id="account_to" name="account_to" type="text" class="mt-1 block w-full"
                                      placeholder="Recipient's account number" :value="old('account_to')"/>
                        @error('account_to')
                        <p class="text-red-500 text-xs mt-1">The provided account does not exist</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="amount" value="Amount"/>
                        <x-text-input id="amount" name="amount" type="text" class="mt-1 block w-full"
                                      placeholder="0.00" :value="old('amount')" />
                        @error('amount')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="one_time_password" value="Verify"/>
                        <x-text-input id="one_time_password" name="one_time_password" type="text" class="mt-1 block w-full"
                                      placeholder="1234"/>
                        @error('one_time_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-primary-button>Transfer</x-primary-button>
                        <a href="{{ route('accounts') }}">
                            <x-secondary-button>Cancel</x-secondary-button>
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{--<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mx-auto">
                <div class="flex py-10 bg-white">
                    <form method="POST" action="{{ route('transactions') }}" class="bg-white ml-10">
                        @csrf
                        <h1 class="text-gray-800 font-bold text-4xl mb-4">Set up the transaction</h1>
                        <div class="flex items-center border-2 py-2 px-3 rounded-2xl mb-4 text-xl">
                            <label for="account_from">From: </label>
                            <select class="px-5 bg-white" name="account_from" id="account_from">
                                @foreach($accounts as $account)
                                    <option value="{{$account->number}}">
                                        {{$account->name}} {{$account->number}} ({{number_format($account->balance, 2)}})
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="flex items-center border-2 py-2 px-3 rounded-2xl text-xl">
                            <label for="account_to">To: </label>
                            <input class="pl-2 outline-none border-none" type="text" name="account_to" id="account_to"
                                   placeholder="Receivers bank account number" value=""/>
                        </div>
                        @error('account_to')
                        <p class="text-red-500 text-xs">The receivers bank account number is invalid</p>
                        @enderror

                        <div class="flex items-center border-2 py-2 px-3 rounded-2xl text-xl mt-4">
                            <label for="amount">Amount:</label>
                            <input class="px-5 outline-none border-none " type="number" step="0.01" name="amount" id="amount"
                                   placeholder="Transferable amount"/>
                        </div>

                        @error('amount')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror

                        <div class="flex items-center border-2 py-2 px-3 rounded-2xl text-xl mt-4">
                            <label for="one_time_password">Enter Code:</label>
                            <input class="px-5 outline-none border-none " type="text" name="one_time_password" id="one_time_password"
                                   placeholder="Authenticate"/>
                        </div>

                        @error('one_time_password')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                        @enderror
                        <button type="submit"
                                class="block w-full bg-sky-900 mt-4 py-2 rounded-2xl text-white font-semibold mb-2">
                            Transfer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>--}}
</x-app-layout>

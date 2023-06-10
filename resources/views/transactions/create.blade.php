<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Start a new Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex md:w-1/2 justify-center py-10 items-center bg-white">
                    <form method="POST" action="/transactions" class="bg-white">
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
                        <button type="submit"
                                class="block w-full bg-sky-900 mt-4 py-2 rounded-2xl text-white font-semibold mb-2">
                            Transfer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        Crypto Transaction History
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">

                <h1 class="text-xl font-medium text-gray-900 mb-6">
                    Crypto Transaction History
                </h1>

                @if(count($accounts) === 0)
                    <p class="text-lg mt-8 mb-4">You don't have any investment accounts!</p>
                    <a href="{{route('accounts.create')}}">
                        <x-secondary-button>Open a new Account
                        </x-secondary-button></a>
                @else
                    <h2 class="text-lg font-medium text-gray-900">
                        Choose an account
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        Select an investment account to view crypto transaction history
                    </p>
                <form method="get" action="{{route('crypto.history')}}" class="mt-6 space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="account" value=""/>
                        <x-selection-input id="account" name="account" class="mt-1 block w-full">
                            @foreach($accounts as $account)
                                <option value="{{$account->id}}">{{$account->number}}</option>
                            @endforeach
                        </x-selection-input>
                    </div>

                    <div>
                        <x-primary-button>Show Transaction History</x-primary-button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>

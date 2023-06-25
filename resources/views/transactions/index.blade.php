<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Choose an account') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <h2 class="text-lg font-medium text-gray-900">
                    Choose an account
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Select the account to view transaction history
                </p>
                <form method="post" action="{{route('transactions.history')}}" class="mt-6 space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="account" value="Account type"/>
                        <x-selection-input id="account" name="account" class="mt-1 block w-full">
                            @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->number}}</option>
                            @endforeach
                        </x-selection-input>
                    </div>

                    <div>
                       {{-- <a href="{{route('transaction.history')}}--}}{{--{{ url('transactions/account/'.$account->getId()) }}--}}{{--">--}}
                            <x-primary-button>Show Transaction History</x-primary-button>

                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>

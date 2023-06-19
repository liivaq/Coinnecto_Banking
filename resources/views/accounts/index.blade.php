<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accounts') }}
        </h2>
    </x-slot>

    <div class="flex gap-x-5 mt-2 mb-6 bg-white p-5 rounded-xl justify-between">
        <div>
            <h1 class="text-2xl font-bold">Account Overview</h1>
        </div>

        <div>
            <a href="{{ route('accounts.create') }}">
                <x-primary-button>Create a new Account</x-primary-button>
            </a>

            <a href="{{ route('transactions.create') }}">
                <x-primary-button type="button">
                    New Transaction
                </x-primary-button>
            </a></div>
    </div>

    <ul role="list" class="flex-wrap gap-y-10">
        @foreach($accounts as $account)
            <li class="flex my-2 bg-white p-5 rounded-xl justify-between ">
                <div class="flex-col mr-20">
                    <div class="font-bold text-2xl">{{ $account->name }}</div>
                    <div class="text-gray-600">{{ $account->number }}</div>
                </div>
                <div class="flex my-auto text-2xl text-gray-600">
                    <div
                        class="mr-6">{{ number_format($account->balance, 2) }} {{strtoupper($account->currency)}}</div>
                    <div>
                        <a href="#">
                            <x-primary-button type="button">
                                Deposit
                            </x-primary-button>
                        </a>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>

</x-app-layout>

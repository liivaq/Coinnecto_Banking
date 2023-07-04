<x-app-layout>
    <x-slot name="header">
        Your Accounts
    </x-slot>

    @if ($message = Session::get('success'))
        <x-flash class="bg-green-200">{{$message}}</x-flash>
    @endif

    @php
        $errors = session('errors');
    @endphp

    @if ($errors && $errors->has('account'))
        <x-flash class="bg-red-200">{{ $errors->first('account') }}</x-flash>
    @endif

    @if ($errors && $errors->has('error'))
        <x-flash class="bg-red-200">{{ $errors->first('error') }}</x-flash>
    @endif

    <div class="gap-x-5 mt-2 mb-6 bg-white p-5 rounded-xl">
        <div class="mb-4">
            <h1 class="text-2xl font-bold">Account Overview</h1>
            <p class="mt-1 text-gray-600 w-3/4">
                Manage your finances and stay informed with our bank account overview,
                providing quick access to your balance, transaction history, and convenient banking features.
            </p>
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
            <li class="flex flex-col my-2 bg-white p-5 rounded-xl
            {{ $account->type === 'investment' ? 'border-l-8 border-yellow-200' : 'border-l-8 border-green-300' }}">
                <div class="flex items-start">
                    <div class="mr-20">
                        <div class="font-bold text-2xl">{{ $account->name }}</div>
                        <div class="text-gray-600">{{ $account->number }}</div>
                        <div class="text-gray-600">{{ ucfirst($account->type) }} account</div>
                    </div>
                    <div class="flex-grow"></div>
                    <div
                        class="text-2xl text-gray-600 pt-10">{{ number_format($account->balance, 2) }} {{strtoupper($account->currency)}}</div>
                </div>
                <div class="flex mt-4">
                    <div class="flex gap-x-4">
                        <div>
                            <a href="{{ route('transactions.history', ['account' => $account->id]) }}">
                                <x-secondary-button>
                                    Transaction History
                                </x-secondary-button>
                            </a>
                        </div>
                        @if($account->type === 'investment')
                            <div>
                                <a href="{{ route('crypto.history', ['account' => $account->id]) }}">
                                    <x-secondary-button>
                                        Crypto Transaction History
                                    </x-secondary-button>
                                </a>
                            </div>
                        @endif
                        @if($account->name !== 'Main Checking Account')
                            <div>
                                <form method="post" action="{{route('account.destroy')}}">
                                    @csrf
                                    @method('delete')
                                    <label for="account"></label>
                                    <input hidden id="account" name="account" value="{{$account->id}}"/>
                                    <x-primary-button class="bg-red-400">
                                        Delete Account
                                    </x-primary-button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
            Dashboard
    </x-slot>

    @if ($message = Session::get('success'))
        <x-flash class="bg-green-200">{{$message}}</x-flash>
    @endif

    <div class="mt-4 mb-6 bg-white p-5 rounded-xl">
        <div>
            <h2 class="text-4xl font-bold">Welcome, {{auth()->user()->name}}!
                <span class="ml-4 absolute animate-waving-hand">👋</span></h2>
            <p class="text-md text-gray-600 mt-4">Explore your banking activities and manage your finances
                efficiently.</p>
        </div>
    </div>
    <div class="container flex gap-4 h-screen sm:h-full">
        <div class="w-1/2 flex flex-col">
            <div class="bg-white p-4 rounded-lg shadow-md text-gray-700 flex flex-col flex-grow">
                <div class="flex = gap-y-4 text-2xl">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building-bank" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M3 21l18 0"></path>
                            <path d="M3 10l18 0"></path>
                            <path d="M5 6l7 -3l7 3"></path>
                            <path d="M4 10l0 11"></path>
                            <path d="M20 10l0 11"></path>
                            <path d="M8 14l0 3"></path>
                            <path d="M12 14l0 3"></path>
                            <path d="M16 14l0 3"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="font-bold mb-4">Accounts</h2>
                    </div>
                </div>
                <div class="flex-grow m-8">
                    <ul class="">
                        <li class="text-2xl font-semibold">{{$account->name}}</li>
                        <li class="text-xl text-gray-600">{{$account->number}}</li>
                        <li class="mt-6 flex text-2xl">
                            Balance:  <span class="font-semibold ml-4">
                                {{number_format($account->balance, 2)}} {{$account->currency}}
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="mt-auto flex justify-end gap-x-4">
                    <a href="{{route('accounts.index')}}">
                        <x-secondary-button>View all Accounts</x-secondary-button>
                    </a>
                    <a href="{{route('accounts.create')}}">
                        <x-secondary-button>Open a new Account</x-secondary-button>
                    </a>
                </div>
            </div>
        </div>

        <div class="w-1/2 bg-white p-4 rounded-lg shadow-md text-gray-700 flex flex-col">
            <div class="flex gap-y-4 text-2xl">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrows-left-right" width="32" height="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M21 17l-18 0"></path>
                        <path d="M6 10l-3 -3l3 -3"></path>
                        <path d="M3 7l18 0"></path>
                        <path d="M18 20l3 -3l-3 -3"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h2 class="font-bold mb-4">Latest Transactions</h2>
                </div>
            </div>
            @if(count($transactions) === 0)
                <div class="mb-4 mt-10 text-xl">
                    You don't have any transactions.
                </div>
            @else
                <div class="flex-grow overflow-auto mb-4">
                    <table class="min-w-full leading-normal">
                        <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Transaction
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Amount
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Date
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($transactions as $transaction)
                            @if($transaction->account_from_id === $account->id || $transaction->account_to_id === $account->id )
                                <tr>
                                    @if($transaction->account_to_id === $account->id )
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                From {{ $transaction->accountFrom->user->name}}</p>
                                            <span>{{ $transaction->accountFrom->number}}</span>
                                        </td>
                                    @endif
                                    @if($transaction->account_to_id !== $account->id )
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-gray-900 whitespace-no-wrap">
                                                To {{ $transaction->accountTo->user->name}}</p>
                                            <span>{{ $transaction->accountTo->number}}</span>
                                        </td>
                                    @endif

                                    @if($transaction->account_to_id === $account->id )
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-green-800 whitespace-no-wrap">
                                                +{{number_format($transaction->amount_converted, 2)}} {{ $account->currency }}
                                            </p>
                                        </td>
                                    @endif
                                    @if($transaction->account_from_id === $account->id )
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <p class="text-red-800 whitespace-no-wrap">
                                                -{{number_format($transaction->amount, 2)}} {{ $account->currency }}
                                            </p>
                                        </td>
                                    @endif
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="mt-auto gap-x-4 flex justify-end">
                @if(count($transactions) > 0)
                <a href="{{route('transactions.index')}}">
                    <x-secondary-button>View Transaction History</x-secondary-button>
                </a>
                @endif
                <a href="{{route('transactions.create')}}">
                    <x-secondary-button>New Transaction</x-secondary-button>
                </a>
            </div>
        </div>
    </div>



</x-app-layout>

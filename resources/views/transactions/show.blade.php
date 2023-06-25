<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction Overview') }}
        </h2>
    </x-slot>

    @if ($message = Session::get('success'))
        <x-flash>{{$message}}</x-flash>
    @endif

    <div class="mt-2 mb-4 bg-white p-5 rounded-xl">
        <div>
            <h1 class="text-2xl font-bold">Transaction overview</h1>
        </div>

        <div class="mt-6">
            <div class="mt-1 text-md text-gray-600">
                {{$account->name}} {{$account->number}}
                BALANCE: {{number_format($account->balance),2}} {{$account->currency}}
            </div>
            <div class="flex mt-8">
                <form class="items-center" method="POST" action="{{route('transactions.filter')}}">
                    @csrf
                    <div class="flex flex-wrap mx-3 mb-4">
                        <div class="w-full md:w-1/4 px-3 mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="from">
                                From Date
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="from" name="from" type="date" placeholder="Select from date">
                        </div>
                        <div class="w-full md:w-1/4 px-3 mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="to">
                                To Date
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="to" name="to" type="date" placeholder="Select to date">
                        </div>
                        <div class="w-full md:w-1/4 px-3 mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="search">
                                Search
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="search" name="search" type="text" placeholder="Search transaction">
                        </div>
                        <div class="w-full md:w-1/4 px-3 mb-4 pt-7">
                            <label>
                                <input hidden name="account" value="{{$account->id}}"/>
                            </label>
                            <x-primary-button>Search</x-primary-button>
                            <x-secondary-button>Reset</x-secondary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md my-6">
        <table class="min-w-full leading-normal">
            <thead>
            <tr>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                >
                    Transaction
                </th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                >
                    Amount
                </th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                >
                    Currency from
                </th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                >
                    Currency to
                </th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                >
                    Exchange Rate
                </th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                >
                    Date
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach ($transactions as $transaction)
                @if($transaction->accountFrom->id === $account->id || $transaction->accountTo->id === $account->id )
                    <tr>
                        @if($transaction->accountTo->id === $account->id )
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    From {{ $transaction->accountFrom->user->name}}</p>
                                <span>{{ $transaction->accountFrom->number}}</span>
                            </td>
                        @endif
                        @if($transaction->accountTo->id !== $account->id )
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    To {{ $transaction->accountTo->user->name}}</p>
                                <span>{{ $transaction->accountTo->number}}</span>
                            </td>
                        @endif

                        @if($transaction->accountTo->id === $account->id )
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-green-800 whitespace-no-wrap">
                                    +{{number_format($transaction->amount_converted, 2)}} {{ $account->currency }}
                                </p>
                            </td>
                        @endif
                        @if($transaction->accountFrom->id === $account->id )
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-red-800 whitespace-no-wrap">
                                    -{{number_format($transaction->amount, 2)}} {{ $account->currency }}
                                </p>
                            </td>
                        @endif
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{$transaction->currency_from}}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{$transaction->currency_to}}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{number_format($transaction->exchange_rate, 2)}}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                        </td>
                    </tr>
                @endif
            @endforeach
            <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>

    {{--
        <div
            class="min-w-full shadow-lg overflow-hidden bg-white px-8 pt-3 rounded-lg">
            @foreach($accounts as $account)
                <div class="p-4 sm:p-8 bg-white rounded-lg">
                    <div class="max-w-2xl">
                        <p class="text-xl font-bold mb-5">{{$account->name}}
                            <span class="text-gray-500 text-sm">{{$account->number}}</span></p>

                        <ul>
                            @foreach ($transactions as $transaction)
                                @if($transaction->accountFrom->id === $account->id || $transaction->accountTo->id === $account->id )
                                    <li class="flex items center space-x-4 py-1 border-b border-gray-300 mb-2">
                                        <div class="flex-1">
                                            <div class="flex-col text-gray-700 font-bold">
                                                @if($transaction->accountTo->id === $account->id )
                                                    <div>
                                                        From {{ $transaction->accountFrom->user->name}}
                                                    </div>
                                                    <div class="text-gray-500 text-sm">
                                                        {{ $transaction->accountFrom->number }}
                                                    </div>
                                                @endif

                                                @if($transaction->accountTo->id !== $account->id )
                                                    <div>
                                                        To {{ $transaction->accountTo->user->name}}
                                                    </div>

                                                    <div class="text-gray-500 text-sm">
                                                        {{ $transaction->accountTo->number }}
                                                    </div>
                                                @endif

                                            </div>

                                            <div class="text-gray-500 text-sm">
                                                {{ $transaction->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                        @if($transaction->accountTo->id === $account->id )
                                            <div class="text-green-600 font-bold">
                                                +{{number_format($transaction->amount_converted, 2)}} {{ $account->currency }}
                                            </div>
                                        @endif

                                        @if($transaction->accountFrom->id === $account->id )
                                            <div class="text-red-600 font-bold">
                                                -{{number_format($transaction->amount, 2)}} {{ $account->currency }}
                                            </div>
                                        @endif
                                    </li>
                                @endif

                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    --}}

</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        Transaction Overview
    </x-slot>

    @if ($message = Session::get('success'))
        <x-flash class="bg-green-200">{{$message}}</x-flash>
    @endif

    <div class="mt-2 mb-4 bg-white px-10 py-4 rounded-xl">
        <div>
            <h1 class="text-2xl font-bold">Transaction overview for <span class="italic">{{$account->name}}</span></h1>
        </div>

        <div class="mt-2">
            <div class="mt-1 text-gray-600">
                <div class="mb-4 text-sm">{{$account->number}}</div>
                <div class="mb-4 text-xl">Total
                    balance: {{ number_format($account->balance, 2) }} {{$account->currency}}</div>
                @if($account->type === 'investment')
                    <div class="mb-4 text-xl">Invested Amount:
                       {{number_format($account->invested_amount,2)}} {{$account->currency}}</div>
                @endif
            </div>
            <div class="flex mt-8">
                <form class="items-center" method="get" action="{{route('transactions.filter')}}">
                    @csrf
                    <div class="flex flex-wrap mb-4">
                        <div class="">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="from">
                                From Date
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="from" name="from" type="date" placeholder="Select from date"
                                value="{{ $from ?? old('from') ?? null }}">
                            @error('from')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="px-3">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="to">
                                To Date
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="to" name="to"  type="date" placeholder="Select to date" value="{{ $to ?? old('to') ?? null }}">
                            @error('to')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="px-3">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="search">
                                Search
                            </label>
                            <input
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="search" name="search" type="text" placeholder="Search transaction"
                                value="{{ $search ?? null }}">
                        </div>
                        <div class="px-3 pt-7">
                            <label>
                                <input hidden name="account" value="{{$account->id}}"/>
                            </label>
                            <x-primary-button>Search</x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md my-6">
        @if(count($transactions) === 0)
            <div class="p-10 text-xl font-semibold">No transactions found.</div>
        @else

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
                </tbody>
            </table>

            <div class="">
                <div>
                    {{ $transactions->appends(['account' => $account->id, 'from' => $from ?? null, 'to' => $to ?? null, 'search' => $search ?? null])->links() }}
                </div>
                @endif
            </div>
    </div>

</x-app-layout>

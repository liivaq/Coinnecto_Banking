<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction Overview') }}
        </h2>
    </x-slot>

    @if ($message = Session::get('success'))
        <x-flash>{{$message}}</x-flash>
    @endif

    @foreach($accounts as $account)
        <div class="bg-white shadow-md rounded my-6">
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
                                    <p class="text-gray-900 whitespace-no-wrap">To {{ $transaction->accountTo->user->name}}</p>
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
                                <p class="text-gray-900 whitespace-no-wrap">{{$transaction->exchange_rate}}</p>
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
    @endforeach

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

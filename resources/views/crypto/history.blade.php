<x-app-layout>
    <x-slot name="header">
        Crypto Transaction Overview
    </x-slot>

    @if ($message = Session::get('success'))
        <x-flash class="bg-green-200">{{$message}}</x-flash>
    @endif

    <div class="mt-2 mb-4 bg-white px-10 py-4 rounded-xl">
        <div>
            <h1 class="text-2xl font-bold">Crypto Transaction overview for <span
                    class="italic">{{$account->name}}</span></h1>
        </div>

        <div class="mt-2">
            <div class="mt-1 text-gray-600">
                <div class="mb-4 text-sm">{{$account->number}}</div>
                <div class="mb-4 text-xl">Total
                    balance: {{ number_format($account->balance, 2) }} {{$account->currency}}</div>
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
                        Name
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                    >
                        Price per one ({{$account->currency}})
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                    >
                        Total Price ({{$account->currency}})
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                    >
                        Amount
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                    >
                        Type
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
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{$transaction->name}}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{$transaction->price_per_one}}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{$transaction->price_per_one * $transaction->amount}}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{$transaction->amount}}</p>
                        </td>
                        @if($transaction->type === 'buy')
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm flex justify center">
                                <p class="text-gray-900 bg-yellow-200 px-4 py-2 rounded-xl whitespace-no-wrap">{{strtoupper($transaction->type)}}</p>
                            </td>
                        @endif
                        @if($transaction->type === 'sell')
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm flex justify center">
                                <p class="text-gray-900 bg-green-300 rounded-xl px-4 py-2 whitespace-no-wrap">{{strtoupper($transaction->type)}}</p>
                            </td>
                        @endif
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{$transaction->created_at}}</p>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="">
                {{ $transactions->appends(['account' => $account->id, 'from' => $from ?? null, 'to' => $to ?? null,'search'=> $search ?? null])->links() }}
            </div>
        @endif
    </div>

</x-app-layout>

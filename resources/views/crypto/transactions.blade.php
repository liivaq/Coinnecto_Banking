<x-app-layout>
    <x-slot name="header">
        Crypto Transaction History
    </x-slot>
    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full leading-normal">
            <thead>
            <tr>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                >
                    Account
                </th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                >
                    Name
                </th>
                <th
                    class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                >
                    Price
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
            </tr>
            </thead>
            <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">Account 1</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{$transaction->name}}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{$transaction->price}}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">{{$transaction->amount}}</p>
                    </td>

                    @if($transaction->type === 'buy')
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
          <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
            <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
            <span class="relative">Buy</span>
          </span>
                    </td>
                    @endif
                    @if($transaction->type === 'sell')
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
          <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
            <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
            <span class="relative">Sell</span>
          </span>
                        </td>
                    @endif
                </tr>
            @endforeach

            <!-- Add more rows as needed -->
            </tbody>
        </table>
    </div>
</x-app-layout>

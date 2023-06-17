<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 pr-10 lg:px-8">
                    {{--     <div
                             class="align-middle rounded-tl-lg rounded-tr-lg inline-block w-full py-4 overflow-hidden bg-white shadow-lg px-12">
                             <div class="flex justify-between">
                                 <div class="inline-flex border rounded w-7/12 px-2 lg:px-6 h-12 bg-transparent">
                                     <div class="flex flex-wrap items-stretch w-full h-full mb-6 relative">
                                         <div class="flex">
                                         <span
                                             class="flex items-center leading-normal bg-transparent rounded rounded-r-none border border-r-0 border-none lg:px-3 py-2 whitespace-no-wrap text-grey-dark text-sm">
                                             <svg width="18" height="18" class="w-4 lg:w-auto" viewBox="0 0 18 18"
                                                  fill="none" xmlns="http://www.w3.org/2000/svg">
                                                 <path
                                                     d="M8.11086 15.2217C12.0381 15.2217 15.2217 12.0381 15.2217 8.11086C15.2217 4.18364 12.0381 1 8.11086 1C4.18364 1 1 4.18364 1 8.11086C1 12.0381 4.18364 15.2217 8.11086 15.2217Z"
                                                     stroke="#455A64" stroke-linecap="round" stroke-linejoin="round"/>
                                                 <path d="M16.9993 16.9993L13.1328 13.1328" stroke="#455A64"
                                                       stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>
                                         </span>
                                         </div>
                                         <input type="text"
                                                class="flex-shrink flex-grow flex-auto leading-normal tracking-wide w-px flex-1 border border-none border-l-0 rounded rounded-l-none px-3 relative focus:outline-none text-xxs lg:text-xs lg:text-base text-gray-500 font-thin"
                                                placeholder="Search">
                                     </div>
                                 </div>
                             </div>
                         </div>--}}
                    @foreach($accounts as $account)
                    <div
                        class="align-middle inline-block min-w-full shadow overflow-hidden bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">
                        <h2>{{$account->number}}</h2>
                        <table class="min-w-full">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">
                                    ID
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    From
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    To
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Amount
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">
                                    Date
                                </th>
                                <th class="px-6 py-3 border-b-2 border-gray-300"></th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            @foreach($transactions as $transaction)
                                @if($transaction->accountFrom->id === $account->id || $transaction->accountTo->id === $account->id )
                                    <tr>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm leading-5 text-gray-800">#{{$transaction->id}}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                            <div
                                                class="text-sm leading-5 text-blue-900">
                                                {{$transaction->accountFrom->number}} ({{$transaction->accountFrom->currency}})
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                                            {{$transaction->accountTo->number}} ({{$transaction->accountTo->currency}})
                                        </td>

                                        @if($transaction->accountTo->id === $account->id )
                                        <td class="px-6 py-4 whitespace-no-wrap border-b bg-green-200 text-blue-900 border-gray-500 text-sm leading-5">
                                            + {{number_format($transaction->amount_converted, 2)}}
                                        </td>
                                        @endif
                                        @if($transaction->accountFrom->id === $account->id )
                                            <td class="px-6 py-4 whitespace-no-wrap border-b bg-red-200 text-blue-900 border-gray-500 text-sm leading-5">
                                                - {{number_format($transaction->amount, 2)}}
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">
                                            {{$transaction->created_at}}
                                        </td>
                                    </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

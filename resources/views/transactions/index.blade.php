<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaction Overview') }}
        </h2>
    </x-slot>
    <div
        class="min-w-full shadow-lg overflow-hidden bg-white px-8 pt-3 rounded-lg">
        @foreach($accounts as $account)
            <div class="p-4 sm:p-8 bg-white rounded-lg">
                <div class="max-w-2xl">
                    <p class="text-xl font-bold mb-5">{{$account->name}}
                        <span class="text-gray-500 text-sm">{{$account->number}}</span></p>

                    @if(count($transactions) === 0)
                        <h3> You have no transactions in this account!</h3>
                    @endif

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


    {{-- @foreach($accounts as $account)

         <div class="my-2 bg-white p-5 rounded-xl ">
             <h2>{{$account->number}}</h2>
             @foreach($transactions as $transaction)
                 <div>
                     {{$transaction->accountFrom->number}}
                 </div>
             @endforeach
         </div>

     @endforeach
 --}}

</x-app-layout>

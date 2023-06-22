<x-app-layout>
    @foreach($transactions as $transaction)
        <div>
            {{ $transaction->price }}
        </div>
        <div>
            {{ $transaction->amount }}
        </div>
    @endforeach
</x-app-layout>

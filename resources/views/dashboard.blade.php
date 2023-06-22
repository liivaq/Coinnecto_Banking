<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="mt-4 mb-6 bg-white p-5 rounded-xl">
        <div>
            <h2 class="text-4xl font-bold">Welcome back, {{strtok(auth()->user()->name, " ")}}!
                <span class="ml-4 absolute animate-waving-hand">👋</span></h2>
            <p class="text-md text-gray-600 mt-4">Explore your banking activities and manage your finances
                efficiently.</p>
        </div>
    </div>
    <div class="container flex gap-4 h-auto sm:h-full">
        <div class="w-1/3 bg-white p-4 rounded-lg shadow-md text-gray-700">
            <h2 class="text-lg font-bold mb-4">Accounts</h2>
            <ul class="list-disc pl-4">
                <li>Account 1</li>
                <li>Account 2</li>
                <li>Account 3</li>
            </ul>
        </div>
        <div class="w-1/3 bg-white p-4 rounded-lg shadow-md text-gray-700">
            <h2 class="text-lg font-bold mb-4">Transactions</h2>
            <ul class="list-disc pl-4">
                <li>Transaction 1</li>
                <li>Transaction 2</li>
                <li>Transaction 3</li>

            </ul>
        </div>
        <div class="w-1/3 bg-white p-4 rounded-lg shadow-md text-gray-700">
            <h2 class="text-lg font-bold mb-4">Crypto</h2>
            <ul class="list-disc pl-4">
                <li>Crypto 1</li>
                <li>Crypto 2</li>
                <li>Crypto 3</li>
            </ul>
        </div>
    </div>
</x-app-layout>

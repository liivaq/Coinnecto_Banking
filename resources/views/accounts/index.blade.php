<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Accounts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <ul role="list" class="divide-y divide-gray-100">
                    @foreach($accounts as $account)
                        <li class="flex justify-between gap-x-6 py-5">
                            <div class="flex gap-x-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-moneybag" width="24"
                                     height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M9.5 3h5a1.5 1.5 0 0 1 1.5 1.5a3.5 3.5 0 0 1 -3.5 3.5h-1a3.5 3.5 0 0 1 -3.5 -3.5a1.5 1.5 0 0 1 1.5 -1.5z"></path>
                                    <path d="M4 17v-1a8 8 0 1 1 16 0v1a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z"></path>
                                </svg>
                                <div class="min-w-0 flex-auto">
                                    <div class="flex">
                                        <p class="text-xl font-semibold leading-6 text-gray-900 mr-20">{{ $account->name }}</p>
                                        <p class="text-xl text-gray-500">{{ number_format($account->balance, 2) }} {{strtoupper($account->currency)}}</p>
                                    </div>

                                    <div class="mt-2 text-m leading-5 text-gray-500"><span
                                            class="font-bold">Account number: </span>{{ $account->number }}
                                    </div>
                                </div>
                                <div class="flex">
                                    <a href="#"><button type="button"
                                                        class="block w-full bg-sky-900 py-2 px-4 rounded-2xl text-white font-semibold mb-2 hover:bg-cyan-600">
                                            Deposit
                                        </button></a>

                                    <a href="/transactions/create"><button type="button"
                                                                           class="block w-full bg-sky-900 py-2 px-4 ml-4 rounded-2xl text-white font-semibold mb-2 hover:bg-cyan-600">
                                            Transfer
                                        </button></a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <a href="/accounts/create"><x-primary-button>Create a new Account</x-primary-button></a>
            </div>
        </div>
    </div>
</x-app-layout>

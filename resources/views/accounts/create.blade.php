<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a new Account') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <h2 class="text-lg font-medium text-gray-900">
                    Create a new Account
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Select your new account's name, type and currency
                </p>
                <form method="post" action="{{ route('accounts.store') }}" class="mt-6 space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Name"/>
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" placeholder="My USD account"/>
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="type" value="Account type"/>
                        <x-selection-input id="type" name="type" type="type" class="mt-1 block w-full">
                            <option>Checking Account</option>
                            <option>Investment Account</option>
                        </x-selection-input>
                    </div>

                    <div>
                        <x-input-label for="currency" value="Currency"/>
                        <x-selection-input id="currency" name="currency" type="currency" class="mt-1 block w-full">
                            @foreach($currencies as $currency)
                            <option>{{$currency->getId()}}</option>
                            @endforeach
                        </x-selection-input>
                    </div>

                    <div>
                        <x-primary-button>Create</x-primary-button>
                        <a href="{{ route('accounts') }}"><x-secondary-button>Cancel</x-secondary-button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>

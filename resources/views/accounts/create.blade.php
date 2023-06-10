<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a new Account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form class="bg-white" action="/accounts/create" method="POST">
                    @csrf
                    <h1 class="text-gray-800 font-bold text-2xl mb-1">Create a new account</h1>

                    <div class="flex items-center border-2 py-2 px-3 rounded-2xl mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <label for="name"></label>
                        <input class="pl-2 outline-none border-none" type="text" name="name" id="name"
                               value="{{ old('name') }}"
                               placeholder="Account name"/>
                    </div>
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <div>
                        <label for="currency">

                        </label>
                        <select class="bg-white text-gray-400 w-full flex items-center border-2 py-2 px-3 rounded-2xl mt-4" name="currency" id="currency">
                            <option value="" selected disabled hidden>
                                Select currency
                            </option>
                            @foreach($currencies as $currency)
                                <option value="{{$currency->getId()}}">{{$currency->getId()}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                            class="block w-full bg-sky-900 mt-4 py-2 rounded-2xl text-white font-semibold mb-2">Create
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

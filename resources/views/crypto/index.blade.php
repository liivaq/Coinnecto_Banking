<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crypto') }}
        </h2>
    </x-slot>

    <div class="bg-white shadow-md rounded-md">
        <div class="overflow-x-auto">
            <div class="min-w-screen min-h-screen flex items-center justify-center">
                <div class="w-full">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Symbol
                            </th>
                            <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Price (EUR)
                            </th>
                            <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Change 1h (%)
                            </th>
                            <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Change 24h (%)
                            </th>
                            <th class="px-6 py-3 bg-gray-100"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cryptoCollection as $crypto)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm leading-5 font-medium text-gray-900">{{$crypto->getName()}}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-900">{{$crypto->getSymbol()}}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-900">{{$crypto->getPrice()}}</div>
                            </td>

                            @if($crypto->getPercentChange1h() > 0)
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-green-500">+{{$crypto->getPercentChange1h()}}</div>
                            </td>
                            @endif

                            @if($crypto->getPercentChange1h() < 0)
                                <td class="px-6 py-4 whitespace-no-wrap">
                                    <div class="text-sm leading-5 text-red-500">{{$crypto->getPercentChange1h()}}</div>
                                </td>
                            @endif

                            @if($crypto->getPercentChange24h() > 0)
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-red-500">+{{$crypto->getPercentChange24h()}}</div>
                            </td>
                            @endif

                            @if($crypto->getPercentChange24h() < 0)
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-red-500">{{$crypto->getPercentChange24h()}}</div>
                            </td>
                            @endif

                            <td class="px-6 py-4 whitespace-no-wrap">
                                <a href="{{ url('crypto/'.$crypto->getId()) }}"><x-secondary-button>Trade</x-secondary-button></a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
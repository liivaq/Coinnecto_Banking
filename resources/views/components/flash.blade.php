<div
    class="fixed inset-x-0 top-0 flex items-center justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-center z-50">
    <div
        x-data="{ show: false }"
        x-init="() => {
            setTimeout(() => show = true, 500);
            setTimeout(() => show = false, 5000);
          }"
        x-cloak x-show="show"
        @click.away="show = false"
        x-transition:enter="transition ease-out duration-10"
        x-transition:enter-start="opacity-0 transform scale-90"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-90"
    {{ $attributes->merge(['class' => 'max-w-sm w-full shadow-lg rounded-lg pointer-events-auto' ]) }}
    {{--class="max-w-sm w-full bg-green-200  shadow-lg rounded-lg pointer-events-auto"--}}>
    <div class="rounded-lg shadow-xs overflow-hidden">
        <div class="p-4">
            <div class="flex items-start">
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm leading-5 font-medium text-gray-900">
                        {{ $slot }}
                        </p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false"
                                class="inline-flex text-gray-400 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                            X
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

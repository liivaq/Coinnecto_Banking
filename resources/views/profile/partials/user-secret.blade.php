<section>
    <header class="mb-6">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Security Key') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Use your security key to make safe transactions - add your key to an authenticator app
            like Google Authenticator, Authy, Microsoft Authenticator etc.
            Register your security code in your chosen app manually or scan the QR code.
            Use your chosen authenticator app when making transactions - enter the code shown in the app.
        </p>
    </header>


    <div x-cloak x-data="{ secretOpen: true }">
            <x-text-input class="mt-1 block w-full" value="{{$user->google2fa_secret}}" name="secret_key"
                          x-bind:type="secretOpen ? 'password' : 'text'"
            />


        <div x-cloak class="flex mt-6 gap-x-4">

            <x-secondary-button x-on:click="secretOpen = !secretOpen">Show Key</x-secondary-button>
            <x-second-modal>
                <x-slot name="title">
                    Show QR Code
                </x-slot>
                {!! $image !!}
            </x-second-modal>
        </div>

    </div>

</section>

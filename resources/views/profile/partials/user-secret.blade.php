<section  >
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Security Key') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('View your security key. Use it to make safe transactions') }}
        </p>
    </header>


    <div >
        <x-text-input class="mt-1 block w-full" value="{{$user->google2fa_secret}}" name="secret_key" type="password"
        />

        <x-secondary-button class="mt-6" >Show Key</x-secondary-button>
    </div>

</section>

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'codes' => $this->generateSecurityCodes()
        ]);

        $user->accounts()->create([
            'name' => 'Main',
            'currency' => 'EUR',
            'number' => $this->generateAccountNumber()
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    private function generateAccountNumber(string $currency = 'EUR', int $length = 21): string
    {
        do {
            $account = strtoupper($currency) . rand(0, 9) . rand(0, 9) . 'ECTO';
            for ($i = 0; strlen($account) < $length; $i++) {
                $account .= rand(0, 9);
            }
        } while (Account::where('number', $account)->exists());

        return $account;
    }

    private function generateSecurityCodes(int $amount = 15, int $codeLength = 4): string
    {
        $codes = [];
        for ($i = 0; $i < $amount; $i++) {
            $codes[] = str_pad(random_int(0, 999999), $codeLength, 0, STR_PAD_LEFT);;
        }

        return json_encode($codes);
    }
}

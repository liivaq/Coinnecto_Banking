<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\User;
use App\Repositories\CurrencyRepository;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository){
        $this->currencyRepository = $currencyRepository;
    }
    public function index()
    {
        $user = User::find(auth()->user()->getAuthIdentifier());
        $accounts = $user->accounts()->get();
        return view('accounts.index', [
            'accounts' => $accounts
        ]);
    }

    public function create()
    {
        $currencies = $this->currencyRepository->all();
        return view('accounts.create', [
            'currencies' => $currencies
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'min:3'],
            'currency' => ['required']
        ]);

        $account = (new Account)->fill([
            'name' => $request->name,
            'currency' => $request->currency,
            'number' => $this->generateAccountNumber($request->currency)
        ]);

        $account->user()->associate(auth()->user());
        $account->save();

        return redirect('/accounts')->with('message', 'Account created successfully');
    }

    private function generateAccountNumber(string $currency, int $length = 21): string
    {
        do {
            $account = strtoupper($currency) . rand(0, 9) . rand(0, 9) . 'ECTO';
            for ($i = 0; strlen($account) < $length; $i++) {
                $account .= rand(0, 9);
            }
        } while (Account::where('number', $account)->exists());

        return $account;
    }
}

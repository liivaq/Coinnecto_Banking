<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Account;
use App\Repositories\CurrencyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class AccountController extends Controller
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository){
        $this->currencyRepository = $currencyRepository;
    }

    public function index()
    {
        $accounts = auth()->user()->accounts()->get();
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
            'currency' => ['required'],
            'type' => ['required']
        ]);

        Account::create([
            'user_id' => auth()->user()->getAuthIdentifier(),
            'name' => $request->name,
            'currency' => $request->currency,
            'number' => $this->generateAccountNumber($request->currency),
            'type' => $request->type
        ]);

        return Redirect::to('/accounts')->with('success', 'Account created Successfully!');

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

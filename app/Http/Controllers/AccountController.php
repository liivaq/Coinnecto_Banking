<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\DeleteAccountRequest;
use App\Models\Account;
use App\Repositories\CurrencyRepository;
use App\Rules\AccountName;
use App\Rules\CheckBalance;
use App\Rules\CheckCryptoBalance;
use App\Rules\CheckMainAccount;
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

    public function store(CreateAccountRequest $request)
    {
        $request->validated();

        Account::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'currency' => $request->currency,
            'number' => $this->generateAccountNumber($request->currency),
            'type' => $request->type
        ]);

        return Redirect::to('/accounts')->with('success', 'Account created Successfully!');

    }

    public function destroy(DeleteAccountRequest $request)
    {
        $request->validated();

        $account = Account::find($request->account);
        $account->delete();

        return Redirect::to('/accounts')->with('success', 'Account deleted Successfully!');
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

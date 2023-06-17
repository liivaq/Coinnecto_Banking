<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\CurrencyRepository;
use App\Rules\Otp;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class TransactionController extends Controller
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }


    public function index()
    {
        $accounts = auth()->user()->accounts()->get();

        $transactions = Transaction::with(['accountTo', 'accountFrom'])
            ->whereIn('account_from_id', $accounts->pluck('id'))
            ->orWhereIn('account_to_id', $accounts->pluck('id'))->get();

        return view('transactions.index', [
            'accounts' => $accounts,
            'transactions' => $transactions,
        ]);
    }

    public function create()
    {
        $user = User::find(auth()->user()->getAuthIdentifier());
        $accounts = $user->accounts()->get();
        return view('transactions.create', [
            'accounts' => $accounts
        ]);
    }

    public function transfer(TransferRequest $request): Redirector|Application|RedirectResponse
    {
        $accountFrom = Account::where('number', $request->account_from)->firstOrFail();
        $accountTo = Account::where('number', $request->account_to)->firstOrFail();

        $request->validated();

        //$convertedAmount = $this->convert($accountFrom->currency, $accountTo->currency, $request->amount);
        $accountFrom->withdraw($request->amount);
        $accountTo->deposit($request->amount);

        $this->saveTransaction($accountFrom, $accountTo, $request->amount);

        return redirect('/transactions');

    }

    private function saveTransaction(Account $from, Account $to, $amount)
    {
        $transaction = (new Transaction())->fill([
            'account_from_id' => $from->id,
            'account_to_id' => $to->id,
            'currency_from' => $from->currency,
            'currency_to' => $to->currency,
            'amount' => $amount,
        ]);

        $transaction->save();
    }

    /* private function convert(string $from, string $to, int $amount): int
     {
         $currencies = $this->currencyRepository->all()->values();


         $fromCurrency = $currencies->where('id', $from)->first();
         dd($currencies->where('id', 'EUR'));
         $senderCurrencyRate = $senderCurrency->rate;

         $recipientCurrency = $currencies->where('symbol', $recipientAccount->currency)->first();
         $recipientCurrencyRate = $recipientCurrency->rate;

         $exchangeRate = $recipientCurrencyRate / $senderCurrencyRate;

     }*/

}

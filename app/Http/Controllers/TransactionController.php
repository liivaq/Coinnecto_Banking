<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use App\Repositories\CurrencyRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
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
            ->orWhereIn('account_to_id', $accounts->pluck('id'))
            ->get();

        return view('transactions.index', [
            'accounts' => $accounts,
            'transactions' => $transactions,
        ]);
    }

    public function create()
    {
        $accounts = auth()->user()->accounts()->get();
        return view('transactions.create', [
            'accounts' => $accounts
        ]);
    }

    public function transfer(TransferRequest $request): Redirector|Application|RedirectResponse
    {
        $accountFrom = Account::where('number', $request->account_from)->firstOrFail();
        $accountTo = Account::where('number', $request->account_to)->firstOrFail();

        $request->validated();

        $converted = $this->convert($accountFrom->currency, $accountTo->currency, $request->amount);

        $convertedAmount = $converted['convertedAmount'];
        $exchangeRate = $converted['exchangeRate'];

        $accountFrom->withdraw($request->amount);
        $accountTo->deposit($convertedAmount);

        $this->saveTransaction(
            $accountFrom,
            $accountTo,
            $request->amount,
            $convertedAmount,
            $exchangeRate
        );

        return redirect(route('transactions.index'));

    }

    private function saveTransaction(
        Account $from,
        Account $to,
        float $amount,
        float $amountConverted,
        float $exchangeRate
    ):void
    {
        $transaction = (new Transaction())->fill([
            'account_from_id' => $from->id,
            'account_to_id' => $to->id,
            'currency_from' => $from->currency,
            'currency_to' => $to->currency,
            'amount' => $amount,
            'amount_converted' => $amountConverted,
            'exchange_rate' => $exchangeRate
        ]);

        $transaction->save();
    }

    private function convert(string $from, string $to, int $amount): array
    {
        $currencies = $this->currencyRepository->all();

        $fromCurrency = $currencies[$from];
        $toCurrency = $currencies[$to];

        $fromCurrencyRate = $fromCurrency->getRate();
        $toCurrencyRate = $toCurrency->getRate();

        $exchangeRate = $toCurrencyRate / $fromCurrencyRate;

        return [
            'convertedAmount' => $exchangeRate * $amount,
            'exchangeRate' => $exchangeRate
        ];
    }
}

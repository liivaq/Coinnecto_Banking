<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Models\Account;
use App\Models\Transaction;
use App\Repositories\CurrencyRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;

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

        return view('transactions.index', [
            'accounts' => $accounts,
        ]);
    }

    public function show(Request $request)
    {
        /** @var Account $account */
        $account = auth()->user()->accounts()->where('id', $request->account)->first();

        $transactions = $account
            ->transactions()
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('transactions.show', [
            'account' => $account,
            'transactions' => $transactions,
        ]);
    }

    public function filter(Request $request)
    {
        $from = $request->from ?? now()->toDateString();
        $to = $request->to ?? now()->toDateString();

        $account = auth()->user()->accounts()->where('id', $request->account)->first();

        $transactions = Transaction::with(['accountTo', 'accountFrom'])
            ->where(function ($query) use ($request) {
                $searchTerm = '%' . $request->search . '%';

                $query->where(function ($query) use ($searchTerm) {
                    $query->whereHas('accountTo', function ($query) use ($searchTerm) {
                        $query->where('number', 'like', $searchTerm);
                    })->orWhereHas('accountFrom', function ($query) use ($searchTerm) {
                        $query->where('number', 'like', $searchTerm);
                    });
                })->orWhereHas('accountFrom.user', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', $searchTerm);
                })->orWhereHas('accountTo.user', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', $searchTerm);
                });
            })
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->paginate(3);

        return view('transactions.show', [
            'search' => $request->search,
            'from' => $from,
            'to' => $to,
            'account' => $account,
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

        return Redirect::to(route('transactions.history', ['account' => $accountFrom->id]))->with('success', 'Transaction successful!');

    }

    private function saveTransaction(
        Account $from,
        Account $to,
        float   $amount,
        float   $amountConverted,
        float   $exchangeRate
    ): void
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

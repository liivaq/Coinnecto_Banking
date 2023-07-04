<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\FailedToGetResponseFromCurrencyApiException;
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

        $transactions = Account::withTrashed()
            ->find($account->id)
            ->transactions()
            ->with(['accountTo' => function ($query) {
                $query->withTrashed();
            }])
            ->with(['accountFrom' => function ($query) {
                $query->withTrashed();
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('transactions.show', [
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
        $request->validated();

        $accountFrom = Account::where('number', $request->account_from)->firstOrFail();
        $accountTo = Account::where('number', $request->account_to)->firstOrFail();

        try {
            $converted = $this->convert($accountFrom->currency, $accountTo->currency, (float)$request->amount);
        } catch (\Exception) {
            return Redirect::back()->with('transactionError', 'There was a problem! Please, try again later.');
        }

        $convertedAmount = $converted['convertedAmount'];
        $exchangeRate = $converted['exchangeRate'];

        $accountFrom->withdraw((float)$request->amount);
        $accountTo->deposit($convertedAmount);

        $this->saveTransaction(
            $accountFrom,
            $accountTo,
            (float)$request->amount,
            $convertedAmount,
            $exchangeRate
        );

        return Redirect::to(route('transactions.history',
            ['account' => $accountFrom->id]))->with('success', 'Transaction successful!');

    }

    public function filter(Request $request)
    {
        $accounts = auth()->user()->accounts();
    }

    private function saveTransaction(
        Account $from,
        Account $to,
        float   $amount,
        float   $amountConverted,
        float   $exchangeRate
    ): void
    {
        Transaction::create([
            'account_from_id' => $from->id,
            'account_to_id' => $to->id,
            'currency_from' => $from->currency,
            'currency_to' => $to->currency,
            'amount' => $amount,
            'amount_converted' => $amountConverted,
            'exchange_rate' => $exchangeRate
        ]);
    }

    private function convert(string $from, string $to, float $amount): array
    {
        try {
            $currencies = $this->currencyRepository->all();
        } catch (FailedToGetResponseFromCurrencyApiException $exception) {
            throw new FailedToGetResponseFromCurrencyApiException();
        }

        $fromCurrencyRate = $currencies[$from]->getRate();
        $toCurrencyRate = $currencies[$to]->getRate();

        $exchangeRate = $toCurrencyRate / $fromCurrencyRate;

        return [
            'convertedAmount' => $exchangeRate * $amount,
            'exchangeRate' => $exchangeRate
        ];
    }
}

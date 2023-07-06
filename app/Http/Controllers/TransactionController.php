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

        $transactions = $account
            ->transactions()
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

        if ($accountFrom->currency !== $accountTo->currency) {
            try {
                $converted = $this->convert($accountFrom->currency, $accountTo->currency, (float)$request->amount);
                $toDeposit = $converted['convertedAmount'];
                $exchangeRate = $converted['exchangeRate'];
            } catch (\Exception) {
                return Redirect::back()->with('transactionError',
                    'There was a problem with currency conversion! Please, try again later.');
            }
        }

        if ($accountFrom->type === 'investment') {
            $toDeposit = $this->checkInvestedBalance($accountFrom, $toDeposit ?? (float)$request->amount);
        }

        $accountFrom->withdraw((float)$request->amount);
        $accountTo->deposit($toDeposit ?? (float)$request->amount);


        $this->saveTransaction(
            $accountFrom,
            $accountTo,
            (float)$request->amount,
            $toDeposit ?? (float)$request->amount,
            $exchangeRate ?? 1
        );

        return Redirect::to(route('transactions.history',
            ['account' => $accountFrom->id]))->with('success', 'Transaction successful!');

    }

    public function filter(Request $request)
    {
        $request->validate([
            'from' => ['required'],
            'to' => ['required']
        ]);

        $account = auth()->user()->accounts()->where('id', $request->account)->first();

        $transactions = Transaction::where(function ($query) use ($account) {
            $query->where('account_from_id', $account->id)
                ->orWhere('account_to_id', $account->id);
        })
            ->whereDate('created_at', '>=', $request->from)
            ->whereDate('created_at', '<=', $request->to)
            ->where(function ($query) use ($request) {
                $searchTerm = $request->search;
                $query->whereHas('accountFrom.user', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%');
                })
                    ->orWhereHas('accountTo.user', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('accountFrom', function ($query) use ($searchTerm) {
                        $query->where('number', 'like', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('accountTo', function ($query) use ($searchTerm) {
                        $query->where('number', 'like', '%' . $searchTerm . '%');
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('transactions.show', [
            'account' => $account,
            'transactions' => $transactions,
            'from' => $request->from,
            'to' => $request->to,
            'search' => $request->search
        ]);
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

    private function checkInvestedBalance(Account $accountFrom, float $amount)
    {

        if ($accountFrom->invested_amount < $amount && $accountFrom->invested_amount > 0) {
            return $amount - (($amount - $accountFrom->invested_amount) * 0.2);
        }

        if ($accountFrom->invested_amount < $amount && $accountFrom->invested_amount < 0) {
            return $amount - ($amount * 0.2);
        }

        return $amount;
    }
}

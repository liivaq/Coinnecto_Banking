<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\CryptoCoinNotFoundException;
use App\Http\Requests\Crypto\CryptoBuyRequest;
use App\Http\Requests\Crypto\CryptoSellRequest;
use App\Models\Account;
use App\Models\CryptoCoin;
use App\Models\CryptoTransaction;
use App\Repositories\CoinMarketCapRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CryptoTransactionController extends Controller
{
    private CoinMarketCapRepository $cryptoRepository;

    public function __construct(CoinMarketCapRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function transactions(): Factory|View|Application
    {
        $accounts = auth()->user()->accounts()->where('type', 'investment')->get();

        return view('crypto.transactions', [
            'accounts' => $accounts,
        ]);
    }

    public function show(Request $request): Factory|View|Application
    {
        $account = auth()->user()->accounts()->where('id', $request->account)->first();

        $transactions = $account
            ->cryptoTransactions()
            ->orderBy('created_at', 'desc')
            ->paginate(3);

        return view('crypto.history', [
            'account' => $account,
            'transactions' => $transactions,
        ]);
    }

    public function buy(CryptoBuyRequest $request): RedirectResponse
    {
        /** @var Account $account */

        $account = Account::where('number', $request->account)->firstOrFail();
        $crypto = $this->cryptoRepository->findById($request->crypto_coin, $account->currency);
        $toWithdraw = $crypto->price * $request->amount;

        if ($toWithdraw > $account->balance) {
            return redirect()->back()->withErrors(['insufficient_balance' => 'Insufficient balance.']);
        }

        $request->validated();

        $account->withdraw($toWithdraw);

        $this->saveUserCrypto($crypto, $request, $account);
        $this->saveCryptoTransaction($crypto, $request, $account);

        return Redirect::to(route('crypto.portfolio'))
            ->with('success', 'You bought ' .
                $request->amount . ' ' . $crypto->symbol . ' for ' .
                number_format($toWithdraw, 2) . ' ' . $account->currency);
    }

    public function sell(CryptoSellRequest $request): RedirectResponse
    {
        try {
            $request->validated();

            /** @var Account $account */
            $account = Account::where('number', $request->account)->firstOrFail();

            $cryptoCoin = $this->cryptoRepository->findById($request->crypto_coin, $account->currency);

            $toDeposit = $cryptoCoin->price * $request->amount;

            $account->deposit($toDeposit);

            $this->saveUserCrypto($cryptoCoin, $request, $account);
            $this->saveCryptoTransaction($cryptoCoin, $request, $account);

            return Redirect::to(route('crypto.portfolio'))->with('success', 'Crypto Sold!');
        } catch (CryptoCoinNotFoundException $exception) {
            return redirect()->back()->withErrors(['coin_not_found' => 'There was an error. Try again later']);
        }
    }

    public function saveCryptoTransaction(CryptoCoin $coin, Request $request, Account $account): void
    {
        CryptoTransaction::create([
            'account_id' => $account->id,
            'cmc_id' => $coin->id,
            'name' => $coin->name,
            'price_per_one' => $coin->price,
            'amount' => $request->amount,
            'type' => $request->type,
        ]);
    }

    public function saveUserCrypto(CryptoCoin $coin, Request $request, Account $account): void
    {
        $account = auth()->user()->accounts()->where('id', $account->id)->first();

        $crypto = $account->cryptos()->firstOrNew([
            'account_id' => $account->id,
            'cmc_id' => $coin->id,
        ]);


        if ($request->type === 'buy') {
            $crypto->amount += $request->amount;
        }

        if ($request->type === 'sell') {
            $crypto->amount -= $request->amount;
        }

        $crypto->save();

        if ($crypto->amount == 0) {
            $crypto->delete();
        }
    }

}

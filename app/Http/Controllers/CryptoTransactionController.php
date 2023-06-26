<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Crypto\CryptoBuyRequest;
use App\Http\Requests\Crypto\CryptoSellRequest;
use App\Models\Account;
use App\Models\CryptoCoin;
use App\Models\CryptoTransaction;
use App\Repositories\CoinMarketCapRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CryptoTransactionController extends Controller
{
    private CoinMarketCapRepository $cryptoRepository;

    public function __construct(CoinMarketCapRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function transactions()
    {
        $accounts = auth()->user()->accounts()->where('type', 'investment')->get();

        $transactions = CryptoTransaction::with(['account'])
            ->whereIn('account_id', $accounts->pluck('id'))
            ->get();

        $ids = $transactions->pluck('cmc_id')->all();
        $cryptos = $this->cryptoRepository->findMultipleById($ids);

        return view('crypto.transactions', [
            'accounts' => $accounts,
            'transactions' => $transactions,
            'cryptos' => $cryptos
        ]);
    }

    public function buy(CryptoBuyRequest $request)
    {
        /** @var Account $account */
        $account = Account::where('number', $request->account)->firstOrFail();

        $request->validated();

        $crypto = $this->cryptoRepository->findById($request->crypto_coin);

        $toWithdraw = $crypto->getPrice() * $request->amount;

        $account->withdraw($toWithdraw);

        $this->saveUserCrypto($crypto, $request);
        $this->saveCryptoTransaction($crypto, $request, $account);

        return Redirect::to(route('crypto.portfolio'))->with('success', 'Purchase Successful!');
    }

    public function sell(CryptoSellRequest $request)
    {
        $request->validated();

        $cryptoCoin = $this->cryptoRepository->findById($request->crypto_coin);

        /** @var Account $account */
        $account = Account::where('number', $request->account)->firstOrFail();

        $toDeposit = $cryptoCoin->getPrice() * $request->amount;

        $account->deposit($toDeposit);

        $this->saveUserCrypto($cryptoCoin, $request);
        $this->saveCryptoTransaction($cryptoCoin, $request, $account);

        return Redirect::to(route('crypto.portfolio'))->with('success', 'Crypto Sold!');
    }

    public function saveCryptoTransaction(CryptoCoin $coin, Request $request, Account $account): void
    {
        $transaction = (new CryptoTransaction())->fill([
            'account_id' => $account->id,
            'cmc_id' => $coin->getId(),
            'name' => $coin->getName(),
            'price' => $coin->getPrice() * $request->amount,
            'amount' => $request->amount,
            'type' => $request->type,
        ]);

        $transaction->save();
    }

    public function saveUserCrypto(CryptoCoin $coin, Request $request): void
    {
        $user = auth()->user();

        $crypto = $user->cryptos()->firstOrNew([
            'cmc_id' => $coin->getId(),
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

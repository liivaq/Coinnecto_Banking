<?php

namespace App\Http\Controllers;

use App\Http\Requests\CryptoTransactionRequest;
use App\Models\Account;
use App\Models\CryptoCoin;
use App\Models\CryptoTransaction;
use App\Models\User;
use App\Models\UserCrypto;
use App\Repositories\CoinMarketCapRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CryptoController extends Controller
{
    private CoinMarketCapRepository $cryptoRepository;

    public function __construct(CoinMarketCapRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function index(): Factory|View|Application
    {
        $cryptoCollection = Cache::get('crypto');

        if (!$cryptoCollection) {
            $cryptoCollection = $this->cryptoRepository->all();
            Cache::put('crypto', $cryptoCollection, now()->addSeconds(120));
        }


        return view('crypto.index', [
            'cryptoCollection' => $cryptoCollection
        ]);
    }

    public function show($id)
    {
        $crypto = $this->cryptoRepository->findById($id);
        $userCrypto = auth()->user()->cryptos()->where('cmc_id', $id)->first();
        $accounts = auth()->user()->accounts()->where('type', 'investment')->get();

        return view('crypto.show', [
            'crypto' => $crypto,
            'accounts' => $accounts,
            'userCrypto' => $userCrypto
        ]);
    }

    public function userCryptos()
    {
        $cryptoIds = auth()->user()->cryptos()->pluck('cmc_id')->toArray();
        $amounts = auth()->user()->cryptos()->pluck('amount', 'cmc_id');

        $allUserCryptos = $this->cryptoRepository->findMultipleById($cryptoIds);

        return view('crypto.portfolio', [
            'amounts' => $amounts,
            'cryptos' => $allUserCryptos
        ]);
    }


    public function buy(Request $request)
    {
        $crypto = $this->cryptoRepository->findById($request->crypto_coin);

        /** @var Account $account */
        $account = Account::where('number', $request->account)->firstOrFail();

        $toWithdraw = $crypto->getPrice() * $request->amount;

        /*$request->validate([
            'account_to' => 'required|exists:accounts,number',
            'amount' => 'required|numeric|min:0.01|max:' . $accountFrom->balance,
            'one_time_password' => ['required', new Otp()]
        ]);*/


        $account->withdraw($toWithdraw);

        $this->saveUserCrypto($crypto, $request);
        $this->saveCryptoTransaction($crypto, $request, $account);

        return redirect(route('accounts.index'));

    }

    public function sell(Request $request)
    {
        dd($request);
    }

    public function saveCryptoTransaction(CryptoCoin $coin, Request $request, Account $account): void
    {
        $transaction = (new CryptoTransaction())->fill([
            'account_id' => $account->id,
            'cmc_id' => $coin->getId(),
            'price' => $coin->getPrice(),
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

        $crypto->user_id = $user->id;
        $crypto->amount += $request->amount;

        $crypto->save();

    }
}

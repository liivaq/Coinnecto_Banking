<?php

namespace App\Http\Controllers;

use App\Repositories\CoinMarketCapRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;

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

    public function search(Request $request)
    {
        try {
            $crypto = $this->cryptoRepository->findBySymbol($request->search);
            return view('crypto.search', [
                'cryptoCollection' => [$crypto]
            ]);
        } catch (Exception $exception) {
            return Redirect::back()->withErrors(['error' => 'Nothing was found with symbol '. $request->search]);
        }
    }

    public function userCryptos()
    {
        try {
            $cryptoIds = auth()->user()->cryptos()->pluck('cmc_id')->toArray();
            $amounts = auth()->user()->cryptos()->pluck('amount', 'cmc_id');
            $allUserCryptos = $this->cryptoRepository->findMultipleById($cryptoIds);
        } catch (Exception $exception) {
            $allUserCryptos = [];
        }

        return view('crypto.portfolio', [
            'amounts' => $amounts,
            'cryptos' => $allUserCryptos
        ]);
    }
}

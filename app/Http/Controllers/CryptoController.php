<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\CryptoCoinNotFoundException;
use App\Repositories\CoinMarketCapRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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

    public function show($id): View|RedirectResponse
    {
        try {
            $accounts = auth()->user()->accounts()
                ->where('type', 'investment')
                ->with(['cryptos' => function ($query) use ($id) {
                    $query->where('cmc_id', $id);
                }])
                ->get();

            $crypto = $this->cryptoRepository->findById($id, $accounts->first()->currency ?? 'EUR');

            return view('crypto.show', [
                'crypto' => $crypto,
                'accounts' => $accounts,
            ]);
        }catch (CryptoCoinNotFoundException){
            return redirect()->back()->withErrors(['error' => 'Sorry! Failed to retrieve information, try again later.']);
        }
    }

    public function search(Request $request): Factory|View|RedirectResponse|Application
    {
        try {
            $request->validate([
                'search' => ['required']
            ]);
            $crypto = $this->cryptoRepository->findBySymbol($request->search);
            return view('crypto.index', [
                'cryptoCollection' => [$crypto]
            ]);
        } catch (CryptoCoinNotFoundException $exception) {
            return Redirect::back()->withErrors([
                'error' => 'Nothing was found. Provide a valid symbol',
            ]);
        }
    }

    public function userCryptos(): Factory|View|Application
    {
        $accounts = auth()->user()
            ->accounts()->where('type', 'investment')
            ->with('cryptos')
            ->get();

        try {
            $cryptoIds = $accounts->pluck('cryptos')->flatten()->pluck('cmc_id')->toArray();
            $cryptoInfo = $this->cryptoRepository->findMultipleById($cryptoIds);
        } catch (CryptoCoinNotFoundException $exception) {
            $cryptoInfo = [];
        }

        return view('crypto.portfolio', [
            'accounts' => $accounts,
            'cryptoInfo' => $cryptoInfo
        ]);
    }

    public function changeValues(): JsonResponse
    {
        $selectedAccount = request()->input('account');
        $cryptoId = request()->input('id');

        $selectedAccount = auth()->user()->accounts()->where('number', $selectedAccount)->first();

        $selectedCurrency = $selectedAccount->currency;
        $userCrypto = $selectedAccount->cryptos()->where('cmc_id', $cryptoId)->first() ?? null;

        $crypto = $this->cryptoRepository->findById($cryptoId, $selectedCurrency ?? 'EUR');

        return response()->json([
            'currency' => $selectedCurrency ?? 'EUR',
            'crypto' => $crypto,
            'amount' => $userCrypto->amount ?? 0
        ]);
    }
}

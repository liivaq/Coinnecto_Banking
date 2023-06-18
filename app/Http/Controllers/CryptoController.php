<?php

namespace App\Http\Controllers;

use App\Repositories\CoinMarketCapRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
}

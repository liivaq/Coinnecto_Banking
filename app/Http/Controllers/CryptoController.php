<?php

namespace App\Http\Controllers;

use App\Repositories\CoinMarketCapRepository;

class CryptoController extends Controller
{
    private CoinMarketCapRepository $cryptoRepository;

    public function __construct(CoinMarketCapRepository $cryptoRepository)
    {
        $this->cryptoRepository = $cryptoRepository;
    }

    public function index()
    {
        $cryptoCollection = $this->cryptoRepository->all();

        return view('crypto.index', [
            'cryptoCollection' => $cryptoCollection
        ]);
    }
}

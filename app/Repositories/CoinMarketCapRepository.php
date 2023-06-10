<?php declare(strict_types=1);

namespace App\Repositories;

use GuzzleHttp\Client;

class CoinMarketCapRepository
{
    const BASE_URI = 'https://pro-api.coinmarketcap.com/v1';
    private Client $client;
    private string $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::BASE_URI
        ]);
        $this->apiKey = env('COIN_MARKET_CAP_KEY');
    }

}

<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\CryptoCoin;
use GuzzleHttp\Client;

class CoinMarketCapRepository
{
    const BASE_URI = 'https://pro-api.coinmarketcap.com/';
    private Client $client;
    private string $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::BASE_URI
        ]);
        $this->apiKey = env('COIN_MARKET_CAP_KEY');
    }

    public function all()
    {
        $response = $this->client->get('v1/cryptocurrency/listings/latest',
            [
                'headers' => [
                    "Accepts" => " application/json",
                    "X-CMC_PRO_API_KEY" => $this->apiKey
                ],
                'query' => [
                    'convert' => 'EUR'
                ]
            ]
        );

        $coins = json_decode($response->getBody()->getContents())->data;

        $cryptoCollection = [];

        foreach ($coins as $coin) {
            $cryptoCollection[$coin->symbol] = $this->buildModel($coin);
        }

        return $cryptoCollection;
    }

    private function buildModel(\stdClass $coin): CryptoCoin
    {
        return new CryptoCoin(
            $coin->id,
            $coin->name,
            $coin->symbol,
            $coin->quote->EUR->price,
            $coin->quote->EUR->percent_change_1h,
            $coin->quote->EUR->percent_change_24h,
        );

    }

}

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
                    'convert' => 'EUR',
                    'limit' => 10
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

    public function findById(string $id, string $currency = 'EUR'): CryptoCoin
    {
        $response = $this->client->get('v1/cryptocurrency/quotes/latest',
            [
                'headers' => [
                    "Accepts" => " application/json",
                    "X-CMC_PRO_API_KEY" => $this->apiKey
                ],
                'query' => [
                    'id' => $id,
                    'convert' => $currency
                ]
            ]
        );

        $coin = json_decode($response->getBody()->getContents())->data->{$id};

        return $this->buildModel($coin, $currency);
    }

    public function findBySymbol(string $symbol): CryptoCoin
    {
        $response = $this->client->get('v1/cryptocurrency/quotes/latest',
            [
                'headers' => [
                    "Accepts" => " application/json",
                    "X-CMC_PRO_API_KEY" => $this->apiKey
                ],
                'query' => [
                    'symbol' => $symbol,
                    'convert' => 'EUR'
                ]
            ]
        );

        $coin = json_decode($response->getBody()->getContents())->data;

        if (!count((array)$coin)) {
            throw new \Exception();
        }

        return $this->buildModel($coin->{strtoupper($symbol)});
    }


    public function findMultipleById(array $ids): array
    {
        $response = $this->client->get('v1/cryptocurrency/quotes/latest',
            [
                'headers' => [
                    "Accepts" => " application/json",
                    "X-CMC_PRO_API_KEY" => $this->apiKey
                ],
                'query' => [
                    'id' => implode(',', $ids),
                    'convert' => 'EUR'
                ]
            ]
        );

        $coins = json_decode($response->getBody()->getContents())->data;

        if (!count((array)$coins)) {
            throw new \Exception();
        }

        $cryptoCollection = [];

        foreach ($coins as $coin) {
            $cryptoCollection[$coin->id] = $this->buildModel($coin);
        }

        return $cryptoCollection;

    }

    private function buildModel(\stdClass $coin, string $currency = 'EUR'): CryptoCoin
    {
        return new CryptoCoin(
            [
                'id' => $coin->id,
                'name' => $coin->name,
                'symbol' => $coin->symbol,
                'price' => $coin->quote->{$currency}->price,
                'iconUrl' => 'https://coinicons-api.vercel.app/api/icon/' . strtolower($coin->symbol),
                'percentChange1h' => $coin->quote->{$currency}->percent_change_1h,
                'percentChange24h' => $coin->quote->{$currency}->percent_change_24h
            ]
        );
    }
}

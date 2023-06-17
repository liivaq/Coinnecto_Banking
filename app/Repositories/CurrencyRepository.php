<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Currency;

class CurrencyRepository
{
    const BASE_URL = "https://www.latvijasbanka.lv/vk/ecb.xml";
    private array $currencies;

    public function __construct()
    {
        $data = json_encode(simplexml_load_file(self::BASE_URL));
        $this->currencies = json_decode($data, true)['Currencies']['Currency'];
    }

    public function all(): array
    {
        $currencyCollection = [];
        foreach ($this->currencies as $currency){
            $currencyCollection[$currency['ID']] = new Currency(
                $currency['ID'],
                (float)$currency['Rate']);
        }

        $currencyCollection['EUR'] = new Currency('EUR', 1);
        return $currencyCollection;
    }
}

<?php declare(strict_types=1);

namespace App\Repositories;

use App\Exceptions\FailedToGetResponseFromCurrencyApiException;
use App\Models\Currency;
use Illuminate\Support\Facades\Cache;

class CurrencyRepository
{
    const BASE_URL = "https://www.latvijasbanka.lv/vk/ecb.xml";

    public function all(): array
    {
        $currencyCollection = Cache::get('currencies');

        if (!$currencyCollection) {
            $data = json_encode(simplexml_load_file(self::BASE_URL));

            if (!$data) {
                throw new FailedToGetResponseFromCurrencyApiException();
            }

            $currencies = json_decode($data, true)['Currencies']['Currency'];

            $currencyCollection = [];
            $currencyCollection['EUR'] = new Currency('EUR', 1);
            foreach ($currencies as $currency) {
                $currencyCollection[$currency['ID']] = new Currency(
                    $currency['ID'],
                    (float)$currency['Rate']);
            }
            Cache::put('currencies',  $currencyCollection, now()->addHours(5));
        }

        return $currencyCollection;
    }
}

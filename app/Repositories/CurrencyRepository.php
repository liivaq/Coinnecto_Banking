<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\Currency;

class CurrencyRepository
{
    const BASE_URL = "https://www.latvijasbanka.lv/vk/ecb.xml";
    private \stdClass $content;

    public function __construct()
    {
        $data = json_encode(simplexml_load_file(self::BASE_URL));
        $this->content = json_decode($data);
    }

    public function currencies(){
        $currencyCollection = [];
        foreach ($this->content->Currencies->Currency as $currency){
            $currencyCollection[] = $this->buildModel($currency);
        }
        return $currencyCollection;
    }


    public function buildModel(\stdClass $currency): Currency
    {
        return new Currency(
            (string)$currency->ID,
            (float)$currency->Rate
        );
    }

}

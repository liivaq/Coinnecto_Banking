<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CryptoCoin extends Model
{
    protected $connection = 'null';
    protected $fillable = [
        'id',
        'name',
        'symbol',
        'price',
        'iconUrl',
        'percentChange1h',
        'percentChange24h'
    ];
   /* private int $id;
    private string $name;
    private string $symbol;
    private float $price;
    private string $iconUrl;
    private float $percentChange1h;
    private float $percentChange24h;

    public function __construct(
        int    $id,
        string $name,
        string $symbol,
        float  $price,
        string $iconUrl,
        float  $percentChange1h,
        float  $percentChange24h
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->price = $price;
        $this->iconUrl = $iconUrl;
        $this->percentChange1h = $percentChange1h;
        $this->percentChange24h = $percentChange24h;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getPercentChange1h(): float
    {
        return $this->percentChange1h;
    }

    public function getPercentChange24h(): float
    {
        return $this->percentChange24h;
    }

    public function getIconUrl(): string
    {
        return $this->iconUrl;
    }*/

}

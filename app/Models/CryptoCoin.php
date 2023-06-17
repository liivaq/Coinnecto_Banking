<?php declare(strict_types=1);

namespace App\Models;

class CryptoCoin
{
    private int $id;
    private string $name;
    private string $symbol;
    private float $price;
    private float $percentChange1h;
    private float $percentChange24h;

    public function __construct(
        int $id,
        string $name,
        string $symbol,
        float $price,
        float $percentChange1h,
        float $percentChange24h
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->symbol = $symbol;
        $this->price = $price;
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

}

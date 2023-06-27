<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CryptoCoin extends Model
{
    protected $fillable = [
        'id',
        'name',
        'symbol',
        'price',
        'iconUrl',
        'percentChange1h',
        'percentChange24h'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}

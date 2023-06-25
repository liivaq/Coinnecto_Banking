<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cryptoTransactions(): HasMany
    {
        return $this->hasMany(CryptoTransaction::class, 'account_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'account_from_id')
            ->orWhere('account_to_id', $this->getKey());
    }

    public function deposit(float $amount): void
    {
        $this->balance += $amount;
        $this->save();
    }

    public function withdraw(float $amount): void
    {
        $this->balance -= $amount;
        $this->save();
    }
}

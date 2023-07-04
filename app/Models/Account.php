<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
class Account extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'account_from_id')
            ->orWhere('account_to_id', $this->id);
    }

    public function cryptos(): HasMany
    {
        return $this->hasMany(UserCrypto::class, 'account_id');
    }

    public function cryptoTransactions(): HasMany
    {
        return $this->hasMany(CryptoTransaction::class, 'account_id');
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

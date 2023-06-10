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

    public function transactionsOut(): HasMany
    {
        return $this->hasMany(Transaction::class, 'account_from_id' );
    }

    public function transactionsIn(): HasMany
    {
        return $this->hasMany(Transaction::class, 'account_to_id' );
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

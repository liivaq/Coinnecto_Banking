<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function accountTo(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_to_id');
    }

    public function accountFrom(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_from_id');
    }

    public function scopeDateRange($query, $from, $to)
    {
        return $query->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to);
    }

    public function scopeSearchByAccountName($query, $searchTerm)
    {
        return $query->whereHas('accountTo', function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%'.$searchTerm.'%');
        });
    }
}

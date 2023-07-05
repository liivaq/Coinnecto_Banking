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
        return $this->belongsTo(Account::class, 'account_to_id')->withTrashed();
    }

    public function accountFrom(): BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_from_id')->withTrashed();
    }

}

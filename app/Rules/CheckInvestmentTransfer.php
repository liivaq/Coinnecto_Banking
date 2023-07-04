<?php

namespace App\Rules;

use App\Models\Account;
use Illuminate\Contracts\Validation\Rule;

class CheckInvestmentTransfer implements Rule
{

    private ?Account $accountTo;

    public function __construct(?string $accountTo)
    {
        $this->accountTo = Account::where('number', $accountTo)->first() ?? null;
    }

    public function passes($attribute, $value)
    {
        $accountFrom = Account::where('number', $value)->first();

        if (!$this->accountTo || $accountFrom->type !== 'investment') {
            return true;
        }
        return $accountFrom->user_id === $this->accountTo->user_id;
    }


    public function message()
    {
        return 'Transactions from investment account are allowed only to your own checking account';
    }
}

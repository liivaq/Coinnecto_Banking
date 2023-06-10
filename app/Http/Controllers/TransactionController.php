<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(){
        $user = User::find(auth()->user()->getAuthIdentifier());
        $transactions = $user->transactions()->get();
        return view('transactions.index', [
            'transactions' => $transactions
        ]);
    }

    public function create()
    {
        $user = User::find(auth()->user()->getAuthIdentifier());
        $accounts = $user->accounts()->get();
        return view('transactions.create', [
            'accounts' => $accounts
        ]);
    }

    public function transfer(Request $request)
    {
        $accountFrom = Account::where('number', $request->account_from)->firstOrFail();
        $accountTo = Account::where('number', $request->account_to)->firstOrFail();

        $request->validate([
            'account_to' => ['required', 'exists:accounts,number'],
            'amount' => ['required', 'numeric', 'min:1', 'max:'.$accountFrom->balance]
        ]);

       /* if($accountFrom->currency !== $accountTo->currency){
            $this->convert($accountFrom->currency, $accountTo->currency, $request->amount);
        }*/

        $accountFrom->balance -= $request->amount;
        $accountTo->balance += $request->amount;

        $accountTo->save();
        $accountFrom->save();

        $this->saveTransaction($accountFrom, $accountTo, $request->amount);

        return redirect('/transactions');

    }

    private function saveTransaction(Account $from, Account $to, $amount)
    {
        $transaction = (new Transaction())->fill([
            'account_from' => $from->number,
            'account_to' => $to->number,
            'currency_from' => $from->currency,
            'currency_to' => $to->currency,
            'amount' => $amount
        ]);

        $transaction->user()->associate(auth()->user());
        $transaction->save();
    }

    private function convert(int $from, int $to, int $amount)
    {

    }

}

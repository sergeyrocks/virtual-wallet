<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Wallet $wallet): Factory|View|Application
    {
        $transactions = $wallet->transactions()->latest()->get();
        $totalIncoming = $wallet->transactions()->where('is_incoming', true)->sum('amount');
        $totalOutgoing = $wallet->transactions()->where('is_incoming', false)->sum('amount');

        return view('transactions.index', compact('wallet', 'transactions', 'totalOutgoing', 'totalIncoming'));
    }

    public function create(Wallet $wallet): Factory|View|Application
    {
        return view('transactions.create', compact('wallet'));
    }

    public function store(TransactionStoreRequest $request, Wallet $wallet): Redirector|Application|RedirectResponse
    {
        $transaction = $request->validated();
        $transaction['is_incoming'] = isset($transaction['is_incoming']) ?
            (boolean) $transaction['is_incoming'] :
            false;
        $transaction['wallet_id'] = $wallet->id;

        $wallet->balance = $transaction['is_incoming'] ?
            bcadd($wallet->balance, $transaction['amount']) :
            bcsub($wallet->balance, $transaction['amount']);

        $wallet->transactions()->save(Transaction::make($transaction));
        $wallet->save();

        return redirect(route('wallets.transactions.index', $wallet))
            ->with('alert', ['type' => 'success', 'message' => 'Transaction created successfully']);
    }

    public function update(
        TransactionUpdateRequest $request,
        Wallet $wallet,
        Transaction $transaction
    ): Redirector|Application|RedirectResponse {
        $transaction->fill($request->validated())->save();

        return redirect(route('wallets.transactions.index', $wallet))
            ->with('alert', ['type' => 'success', 'message' => 'Transaction updated successfully']);
    }

    public function destroy(Wallet $wallet, Transaction $transaction): Redirector|Application|RedirectResponse
    {
        $wallet->balance = $transaction->is_incoming ?
            bcsub($wallet->balance, $transaction->amount) :
            bcadd($wallet->balance, $transaction->amount);
        $wallet->save();
        $transaction->delete();

        return redirect(route('wallets.transactions.index', $wallet))
            ->with('alert', ['type' => 'danger', 'message' => 'Transaction successfully removed']);
    }
}

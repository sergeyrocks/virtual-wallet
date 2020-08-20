<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Models\Transaction;
use App\Models\Wallet;

class TransactionController extends Controller
{

    /**
     * TransactionController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Wallet $wallet)
    {
        $transactions = $wallet->transactions()->get();
        return view('transactions.index', compact('wallet', 'transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Wallet $wallet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create(Wallet $wallet)
    {
        return view('transactions.create', compact('wallet'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(TransactionStoreRequest $request, Wallet $wallet)
    {
        $transaction = $request->validated();
        $transaction['is_incoming'] = isset($transaction['is_incoming']) ?
            (boolean) $transaction['is_incoming'] :
            false;
        $transaction['wallet_id'] = $wallet->id;
        $wallet->balance = $transaction['is_incoming'] ?
            bcadd($wallet->balance, $transaction['amount']) :
            bcsub($wallet->balance, $transaction['amount']);
        Transaction::create($transaction);
        $wallet->save();

        return redirect(route('wallets.transactions.index', $wallet))
            ->with('alert', ['type' => 'success', 'message' => 'Transaction created successfully']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TransactionUpdateRequest $request
     * @param Transaction              $transaction
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(TransactionUpdateRequest $request, Wallet $wallet, Transaction $transaction)
    {
        $transaction->fill($request->validated())->save();
        return redirect(route('wallets.transactions.index', $wallet))
            ->with('alert', ['type' => 'success', 'message' => 'Transaction updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect(route('wallets.transactions.index'))
            ->with('alert', ['type' => 'danger', 'message' => 'Transaction successfully removed']);
    }
}

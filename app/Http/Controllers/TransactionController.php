<?php

namespace App\Http\Controllers;

use App\Dto\TransactionCreate;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\TransactionService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class TransactionController extends Controller
{
    public function index(Wallet $wallet): Factory|View|Application
    {
        $transactions = $wallet->transactions()->latest()->get();
        $totalIncoming = $wallet->transactions()->where('is_incoming', true)->sum('amount');
        $totalOutgoing = $wallet->transactions()->where('is_incoming', false)->sum('amount');

        return view('transactions.index', compact('wallet', 'transactions', 'totalOutgoing', 'totalIncoming'));
    }

    public function create(Wallet $wallet): Factory|Response|\Illuminate\View\View
    {
        return view('transactions.create', compact('wallet'));
    }

    public function store(
        TransactionStoreRequest $request,
        Wallet $wallet,
        TransactionService $service
    ): Redirector|Application|RedirectResponse
    {
        $data = new TransactionCreate(...$request->validated());
        $service->create($wallet, $data);

        return redirect(route('wallets.transactions.index', $wallet))
            ->with('alert', ['type' => 'success', 'message' => 'Transaction created successfully']);
    }

    public function update(
        TransactionUpdateRequest $request,
        Transaction $transaction
    ): Response|Redirector|RedirectResponse {
        $transaction->fill($request->validated())->save();

        return redirect(route('wallets.transactions.index', $transaction->wallet_id))
            ->with('alert', ['type' => 'success', 'message' => 'Transaction updated successfully']);
    }

    public function destroy(Transaction $transaction, TransactionService $service): Redirector|Application|RedirectResponse
    {
        $service->delete($transaction);

        return redirect(route('wallets.transactions.index', $transaction->wallet))
            ->with('alert', ['type' => 'danger', 'message' => 'Transaction successfully removed']);
    }
}

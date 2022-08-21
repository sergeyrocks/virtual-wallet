<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletStoreRequest;
use App\Http\Requests\WalletUpdateRequest;
use App\Models\Wallet;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index(): Factory|View|Application
    {
        $wallets = Auth::user()->wallets()->latest()->get();

        return view('wallets.index', compact('wallets'));
    }

    public function create(): Factory|View|Application
    {
        return view('wallets.create');
    }

    public function store(WalletStoreRequest $request): Redirector|Application|RedirectResponse
    {
        $wallet = $request->validated();
        $wallet['user_id'] = Auth::user()->id;
        Wallet::create($wallet);

        return redirect(route('wallets.index'))
            ->with('alert', ['type' => 'success', 'message' => 'Wallet created successfully']);
    }

    public function edit(Wallet $wallet): Factory|View|Application
    {
        return view('wallets.edit', compact('wallet'));
    }

    public function update(WalletUpdateRequest $request, Wallet $wallet): Redirector|Application|RedirectResponse
    {
        $wallet->fill($request->validated())->save();

        return redirect(route('wallets.edit', $wallet))
            ->with('alert', ['type' => 'success', 'message' => 'Wallet title changed successfully']);
    }

    public function destroy(Wallet $wallet): Redirector|Application|RedirectResponse
    {
        $wallet->delete();

        return redirect(route('wallets.index'))
            ->with('alert', ['type' => 'danger', 'message' => 'Wallet successfully removed']);
    }
}

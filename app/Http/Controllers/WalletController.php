<?php

namespace App\Http\Controllers;

use App\Http\Requests\WalletStoreRequest;
use App\Http\Requests\WalletUpdateRequest;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{

    /**
     * WalletController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $wallets = Auth::user()->wallets()->latest()->get();

        return view('wallets.index', compact('wallets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('wallets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WalletStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function store(WalletStoreRequest $request)
    {
        $wallet = $request->validated();
        $wallet['user_id'] = Auth::user()->id;
        Wallet::create($wallet);

        return redirect(route('wallets.index'))
            ->with('alert', ['type' => 'success', 'message' => 'Wallet created successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Wallet $wallet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Wallet $wallet)
    {
        return view('wallets.edit', compact('wallet'));
    }

    /**
     * @param WalletUpdateRequest $request
     * @param Wallet              $wallet
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(WalletUpdateRequest $request, Wallet $wallet)
    {
        $wallet->fill($request->validated())->save();

        return redirect(route('wallets.edit', $wallet))
            ->with('alert', ['type' => 'success', 'message' => 'Wallet title changed successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Wallet $wallet
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Wallet $wallet)
    {
        $wallet->delete();

        return redirect(route('wallets.index'))
            ->with('alert', ['type' => 'danger', 'message' => 'Wallet successfully removed']);
    }
}

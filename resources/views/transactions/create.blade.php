@extends('layouts.app')

<?php
    /**
     * @var \App\Models\Wallet $wallet
     */
?>

@section('content')
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <h1 class="text-center">Create transaction</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(session('alert'))
                    <div class="row no-gutters">
                        <div class="col">
                            @include('components.alert', ['type' => session('alert')['type'], 'slot' => session('alert')['message']])
                        </div>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('wallets.transactions.store', $wallet) }}"
                              method="POST"
                              class="mx-auto"
                              style="max-width: 550px;">
                            @csrf
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="is_incoming"
                                           value=1"
                                           @if(old('transaction.is_incoming') === '1')
                                           checked
                                           @endif
                                           id="incoming">
                                    <label class="form-check-label" for="incoming">
                                        Incoming
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="amount" class="col-form-label">Amount</label>
                                <div>
                                    <input id="amount"
                                           type="text"
                                           class="form-control @error('amount') is-invalid @enderror"
                                           name="amount"
                                           value="{{ old('amount') }}"
                                           required>

                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="reference" class="col-form-label">Reference</label>
                                <div>
                                    <input id="reference"
                                           type="text"
                                           class="form-control @error('reference') is-invalid @enderror"
                                           name="reference"
                                           value="{{ old('reference') }}"
                                           required>

                                    @error('reference')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="payer" class="col-form-label">Payer</label>
                                <div>
                                    <input id="payer"
                                           type="text"
                                           class="form-control @error('payer') is-invalid @enderror"
                                           name="payer"
                                           value="{{ old('payer') }}">

                                    @error('payer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="beneficiary" class="col-form-label">Beneficiary</label>
                                <div>
                                    <input id="beneficiary"
                                           type="text"
                                           class="form-control @error('beneficiary') is-invalid @enderror"
                                           name="beneficiary"
                                           value="{{ old('beneficiary') }}">

                                    @error('beneficiary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('wallets.index') }}" class="btn btn-link">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

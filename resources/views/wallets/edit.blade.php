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
                <h1 class="text-center">Wallet "{{ $wallet->title }}" edit</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        @if(session('alert'))
                            <div class="row no-gutters">
                                <div class="col">
                                    @include('components.alert', ['type' => session('alert')['type'], 'slot' => session('alert')['message']])
                                </div>
                            </div>
                        @endif
                        <form action="{{ route('wallets.update', $wallet) }}"
                              method="POST"
                              class="mx-auto"
                              style="max-width: 550px;">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="title" class="col-form-label">
                                    Title
                                </label>

                                <div>
                                    <input id="title"
                                           type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           name="title"
                                           value="{{ old('title') ?? $wallet->title }}"
                                           required>

                                    @error('title')
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

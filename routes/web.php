<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * @see \Laravel\Ui\AuthRouteMethods::auth()
 */
Auth::routes([
    'reset'   => false,
    'confirm' => false,
    'verify'  => false,
]);

Route::get('/', fn() => redirect()->route('wallets.index'))->name('home');
Route::resource('wallets', WalletController::class)->except('show');
Route::resource('wallets.transactions', TransactionController::class)->except(['show', 'edit']);

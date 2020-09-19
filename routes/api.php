<?php

use App\Http\Controllers\Api\Buyer\BuyerController;
use App\Http\Controllers\Api\Buyer\BuyerProductController;
use App\Http\Controllers\Api\Buyer\BuyerSellerController;
use App\Http\Controllers\Api\Buyer\BuyerTransactionController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Seller\SellerController;
use App\Http\Controllers\Api\Transaction\TransactionCategoryController;
use App\Http\Controllers\Api\Transaction\TransactionController;
use App\Http\Controllers\Api\Transaction\TransactionSellerController;
use App\Http\Controllers\Api\User\UserController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('buyers', BuyerController::class)->only(['index', 'show']);
Route::resource('buyers.transactions', BuyerTransactionController::class)->only(['index']);
Route::resource('buyers.products', BuyerProductController::class)->only(['index']);
Route::resource('buyers.sellers', BuyerSellerController::class)->only(['index']);

Route::resource('categories', CategoryController::class)->except([
    'create', 'edit'
]);

Route::resource('products', ProductController::class)->only([
    'index', 'show'
]);

Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
Route::resource('transactions.categories', TransactionCategoryController::class)->only(['index']);
Route::resource('transactions.sellers', TransactionSellerController::class)->only(['index']);

Route::resource('sellers', SellerController::class)->only([
    'index', 'show'
]);

Route::resource('users', UserController::class)->except([
    'create', 'edit'
]);

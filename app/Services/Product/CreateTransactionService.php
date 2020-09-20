<?php

namespace App\Services\Product;

use App\Exceptions\AppError;
use App\Http\Requests\Product\CreateTransactionRequest;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateTransactionService
{
    /**
     * Execute the service
     * 
     * @param  CreateTransactionRequest  $request
     * @param  Product  $product
     * @param  User  $buyer
     * @throws AppError
     * @return array  $categories
     */
    public function execute(CreateTransactionRequest $request, Product $product, User $buyer)
    {
        if ($buyer->id == $product->seller_id) {
            throw new AppError('The buyer must be different from the seller', 409);
        }

        if (!$buyer->isVerified()) {
            throw new AppError('Buyer must be a verified user', 409);
        }

        if (!$product->seller->isVerified()) {
            throw new AppError('Seller must be a verified user', 409);
        }

        if (!$product->isAvailable()) {
            throw new AppError('Product must be available', 409);
        }

        if ($product->quantity < $request->quantity) {
            throw new AppError('The product has no quantity available for this transaction', 409);
        }

        $transaction = DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ]);

            return $transaction;
        });

        return $transaction;
    }
}

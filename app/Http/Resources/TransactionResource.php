<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "quantity" => $this->quantity,
            "buyer_id" => $this->buyer_id,
            "product_id" => $this->product_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('transactions.show', $this->id)
                ],
                [
                    'rel' => 'transaction.categories',
                    'href' => route('transactions.categories.index', $this->id)
                ],
                [
                    'rel' => 'transaction.seller',
                    'href' => route('transactions.sellers.index', $this->id)
                ],
                [
                    'rel' => 'buyer',
                    'href' => route('buyers.show', $this->buyer_id)
                ],
                [
                    'rel' => 'product',
                    'href' => route('products.show', $this->product_id)
                ],
            ]
        ];
    }
}

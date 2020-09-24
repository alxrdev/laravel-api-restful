<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "name" => $this->name,
            "description" => $this->description,
            "quantity" => $this->quantity,
            "status" => $this->status,
            "image" => $this->image,
            "seller_id" => $this->seller_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('products.show', $this->id)
                ],
                [
                    'rel' => 'product.categories',
                    'href' => route('products.categories.index', $this->id)
                ],
                [
                    'rel' => 'product.buyers',
                    'href' => route('products.buyers.index', $this->id)
                ],
                [
                    'rel' => 'product.transactions',
                    'href' => route('products.transactions.index', $this->id)
                ],
                [
                    'rel' => 'seller',
                    'href' => route('sellers.show', $this->seller_id)
                ],
            ]
        ];
    }
}

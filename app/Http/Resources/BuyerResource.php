<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BuyerResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'admin' => $this->admin,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('buyers.show', $this->id)
                ],
                [
                    'rel' => 'buyer.categories',
                    'href' => route('buyers.categories.index', $this->id)
                ],
                [
                    'rel' => 'buyer.products',
                    'href' => route('buyers.products.index', $this->id)
                ],
                [
                    'rel' => 'buyer.sellers',
                    'href' => route('buyers.sellers.index', $this->id)
                ],
                [
                    'rel' => 'buyer.transactions',
                    'href' => route('buyers.transactions.index', $this->id)
                ]
            ]
        ];
    }
}

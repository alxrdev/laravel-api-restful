<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
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
                    'href' => route('sellers.show', $this->id)
                ],
                [
                    'rel' => 'seller.buyers',
                    'href' => route('sellers.buyers.index', $this->id)
                ],
                [
                    'rel' => 'seller.categories',
                    'href' => route('sellers.categories.index', $this->id)
                ],
                [
                    'rel' => 'seller.products',
                    'href' => route('sellers.products.index', $this->id)
                ],
                [
                    'rel' => 'seller.transactions',
                    'href' => route('sellers.transactions.index', $this->id)
                ]
            ]
        ];
    }
}

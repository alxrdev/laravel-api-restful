<?php

namespace App\Services\Seller;

use App\Exceptions\AppError;
use App\Http\Requests\Seller\UpdateProductRequest;
use App\Models\Product;
use App\Models\Seller;
use App\Traits\CheckProductOwner;
use Illuminate\Support\Facades\Storage;

class UpdateProductService
{
    use CheckProductOwner;

    /**
     * @var UpdateProductRequest
     */
    private $request;

    /**
     * @var Seller
     */
    private $seller;

    /**
     * @var Product
     */
    private $product;

    /**
     * Class constructor
     * 
     * @param  UpdateProductRequest     $request
     * @param  Seller                   $seller
     * @param  Product                  $product
     */
    public function __construct(UpdateProductRequest $request, Seller $seller, Product $product)
    {
        $this->request = $request;
        $this->seller = $seller;
        $this->product = $product;
    }

    /**
     * Execute the service
     * 
     * @throws AppError
     * @return Product                  $product
     */
    public function execute(): Product
    {
        $this->checkProductOwner($this->seller, $this->product);

        $this->fillProduct();

        $this->handleStatusChange();

        $this->handleImageChange();

        $this->productHasNotChanged();

        $this->product->save();

        return $this->product;
    }

    private function fillProduct()
    {
        $this->product->fill($this->request->only([
            'name',
            'description',
            'quantity'
        ]));
    }

    private function handleStatusChange()
    {
        if ($this->request->has('status')) {
            $this->product->status = $this->request->status;

            if ($this->product->isAvailable() && $this->product->categories()->count() == 0) {
                throw new AppError('An available product must have at least one category', 409);
            }
        }
    }

    private function handleImageChange()
    {
        if ($this->request->hasFile('image')) {
            Storage::delete($this->product->image);
            $this->product->image = $this->request->image->store('');
        }
    }

    private function productHasNotChanged()
    {
        if ($this->product->isClean()) {
            throw new AppError('At least one value must be modified to update the product.', 409);
        }
    }
}

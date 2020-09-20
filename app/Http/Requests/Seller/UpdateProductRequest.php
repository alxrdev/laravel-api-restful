<?php

namespace App\Http\Requests\Seller;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'quantity' => 'integer:min:1',
            'status' => 'in: ' . Product::PRODUCT_AVAILABLE . ',' . Product::PRODUCT_UNAVAILABLE,
            'image' => 'image'
        ];
    }
}

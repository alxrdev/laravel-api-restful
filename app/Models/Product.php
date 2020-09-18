<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const PRODUCT_AVAILABLE = 'available';
    const PRODUCT_UNAVAILABLE = 'unavailable';

    protected $fillable = [
        'name', 'description', 'quantity', 'status', 'image', 'seller_id'
    ];

    public function isAvailable(): Bool
    {
        return $this->status == Product::PRODUCT_AVAILABLE;
    }

    public function seller()
    {
        return $this->belongsTo('App\Models\Seller');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }
}

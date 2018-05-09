<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price', 'discount', 'quantity', 'image'
    ];

    public function products_t()
    {
        return $this->hasMany('App\ProductsT');
    }


}

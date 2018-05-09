<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsT extends Model
{
    protected $table = 'products_t';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'code', 'name', 'description'
    ];

    public function products()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }
}

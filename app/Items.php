<?php

namespace App;
Use App\Products;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    public function Products() {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
<?php

namespace App;
Use App\Items;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public function Items() {
        return $this->hasMany(Items::class, 'id');
    }
}
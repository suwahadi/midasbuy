<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    protected $table = 'transactions';

    protected $fillable = ['product_id', 'product_code', 'total'];

    protected $hidden = [
    ];

    public function Items()
    {
        return $this->belongsTo(Items::class, 'product_id');
    }

    public function PaymentChannels()
    {
        return $this->belongsTo(PaymentChannels::class, 'payment_channel_id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
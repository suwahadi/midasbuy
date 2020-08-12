<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentChannels extends Model
{
    protected $table = 'payment_channels';

    protected $hidden = [
    ];

    public function Transactions()
    {
        return $this->hasMany(Transactions::class, 'id');
    }

    public function Deposit()
    {
        return $this->hasMany(Deposit::class, 'id');
    }
    
}
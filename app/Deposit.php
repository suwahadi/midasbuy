<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    public $table = "deposit";

    protected $hidden = [
    
    ];

    public function PaymentChannels()
    {
        return $this->belongsTo(PaymentChannels::class, 'payment_channel');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'userid');
    }

}
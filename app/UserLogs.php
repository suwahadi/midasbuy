<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLogs extends Model
{
    public $table = "users_logs";

    protected $hidden = [
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'userid');
    }

}
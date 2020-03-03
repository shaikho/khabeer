<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    protected $fillable = [
        'user_id', 'providor_id', 'admin_id','level','credit','notes','datetime'
    ];
}

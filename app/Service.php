<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'servicename','servicenamearabic','description','arabicdescription','iconurl'
    ];
}

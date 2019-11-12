<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubService extends Model
{
    protected $fillable = [
        'subservicename','subservicenamearabic','price','status','slug','description','descriptionarabic','serviceid'
    ];
}

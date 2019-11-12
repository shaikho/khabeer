<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceProvidor extends Model
{
    protected $fillable = [
        'username', 'phonenumber', 'buildingno','unitno','docs','profileimg','role','postalcode', 'neighborhood','nationalid','nationaladdress','rate','clients','type','approved','code','active','requestid','subserviceid'
    ];
}

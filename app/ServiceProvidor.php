<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class ServiceProvidor extends Authenticatable
{
    use Notifiable,HasApiTokens;

    protected $fillable = [
        'username', 'phonenumber', 'buildingno','unitno','docs','profileimg','role','postalcode', 'neighborhood','nationalid','nationaladdress','rate','clients','type','approved','code','active','requestid','subserviceid'
    ];
}

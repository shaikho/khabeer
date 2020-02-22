<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use Notifiable,HasApiTokens;
    
    protected $fillable = [
        'username','password','phonenumber','profileimg','role','area'
    ];
}

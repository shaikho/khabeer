<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RM extends Model
{
    protected $fillable = [
        'subno','subserviceprice','subservicename','subservicearabicname','enddate','userid','providerid','subserviceslug','cancelled','cancelmessage','status','user_lang','userauth','providorlang','providorauth'
    ];
}

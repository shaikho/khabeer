<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\ServiceProvidor;
use App\User;

class RequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $serviceprovider = ServiceProvidor::findOrFail($request->providerid);
        $user = User::findOrFail($request->userid);

        return [
            //'id' => $request->id,
            'subno' => $request->subno,
            'subserviceprice' => $request->subserviceprice,
            'subservicename' => $request->subservicename,
            'subservicearabicname' => $request->subservicearabicname,
            'startdate' => $request->startdate,
            'enddate' => $request->enddate,
            'userid' => $request->userid,
            'providerid' => $request->providerid,
            'location' => $request->location,
            'subserviceslug' => $request->subserviceslug,
            'cancelled' => $request->cancelled,
            'cancelmessage' => $request->cancelmessage,
            'status' => $request->status,
            'user_lang' => $request->user_lang,
            'userauth' => $request->userauth,
            'providorlang' => $request->providorlang,
            'providorauth' => $request->providorauth,
            'providorname' => $serviceprovider->username,
            'customername' => $user->username,
            'created_at' => $request->created_at,
            'updated_at' => $request->updated_at,
        ];
        //return parent::toArray($request);
    }
}

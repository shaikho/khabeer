<?php

namespace App\Http\Controllers;

use App\Http\Resources\ServiceProvidorResource;
use Illuminate\Http\Request;
use App\ServiceProvidor;

class ServiceProvidorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceprovider = ServiceProvidor::All();
        return new ServiceProvidorResource($serviceprovider);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $serviceprovider = $request->isMethod('put') ? ServiceProvidor::findOrFail
        ($request->id) : new ServiceProvidor;
        
        //$serviceprovider->username = $request->input('username');
        if (!empty($request->input('username'))) {
            $serviceprovider->username = $request->input('username');
        }
        else {
            return [
                'Message'=>'username is required.'
            ];
        }
        //$serviceprovider->phonenumber = $request->input('phonenumber');
        if (!empty($request->input('phonenumber'))) {
            $serviceprovider->phonenumber = $request->input('phonenumber');
        }
        else {
            return [
                'Message'=>'phonenumber is required.'
            ];
        }
        //$serviceprovider->password = $request->input('password');
        if (!empty($request->input('password'))) {
            $serviceprovider->password = $request->input('password');
        }
        else {
            return [
                'Message'=>'password is required.'
            ];
        }
        $serviceprovider->buildingno = $request->input('buildingno');
        $serviceprovider->unitno = $request->input('unitno');
        $serviceprovider->docs = $request->input('docs');
        $serviceprovider->profileimg = $request->input('profileimg');
        $serviceprovider->role = $request->input('role');
        $serviceprovider->postalcode = $request->input('postalcode');
        $serviceprovider->neighborhood = $request->input('neighborhood');
        $serviceprovider->nationalid = $request->input('nationalid');
        $serviceprovider->nationaladdress = $request->input('nationaladdress');
        $serviceprovider->rate = $request->input('rate');
        $serviceprovider->clients = $request->input('clients');
        $serviceprovider->type = $request->input('type');
        $serviceprovider->approved = $request->input('approved');
        $serviceprovider->code = $request->input('code');
        $serviceprovider->active = $request->input('active');
        $serviceprovider->requestid = $request->input('requestid');
        $serviceprovider->subserviceid = $request->input('subserviceid');

        if($serviceprovider->save()){
            return new ServiceProvidorResource($serviceprovider);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $serviceprovider = ServiceProvidor::findOrFail($id);
        return new ServiceProvidorResource($serviceprovider);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $serviceprovider = ServiceProvidor::findOrFail($id);

        if($serviceprovider->delete()){
            return new ServiceProvidorResource($serviceprovider);
        }
    }

    public function rate(Request $request,$id){
        $rate = 0;$count = 0;
        $request->validate([
            'rate'=>'required'
        ]);
        $serviceprovider = ServiceProvidor::findOrFail($id);
        $oldrating = $serviceprovider->rate;
        $passedrating = $request->rate;
        $token = strtok($oldrating, ",");
        $count = $token;
        $token = strtok(",");
        $rate = $token;
        $result = $count*$rate+5/$count+1;
        echo $result;
        echo "\nThe rate is : " . $rate  . "\n";
        echo "The count is : " . $count;
    }

    public function uploadprofileimg(Request $request) {
        
    }
    
}

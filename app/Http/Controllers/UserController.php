<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $User = User::All();
        return new UserResource($User);
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
        $user = $request->isMethod('put') ? User::findOrFail
        ($request->id) : new User;
        
        //$user->username = $request->input('username');
        if (empty($request->input('username'))) {
            return [
                'Message'=>'username is required.'
            ];
        }
        else {
            $user->username = $request->input('username');
        }
        //$user->password = $request->input('password');
        if (empty($request->input('password'))) {
            return [
                'Message'=>'password is required.'
            ];
        }
        else {
            $user->password = $request->input('password');
        }
        //$user->phonenumber = $request->input('phonenumber');
        if (empty($request->input('phonenumber'))) {
            return [
                'Message'=>'phonenumber is required.'
            ];
        }
        else {
            $user->phonenumber = $request->input('phonenumber');
        }
        $user->profileimg = $request->input('profileimg');
        $user->location = $request->input('location');
        $user->role = $request->input('role');
        $user->rate = $request->input('rate');
        $user->active = $request->input('active');
        $user->serviceproviderid = $request->input('serviceproviderid');
        $user->balance = $request->input('balance');

        if($user->save()){
            return new UserResource($user);
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
        $user = User::findOrFail($id);
        return new UserResource($user);
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
        $user = User::findOrFail($id);

        if($user->delete()){
            return new ServiceResource($user);
        }
    }

    public function otpuser(Request $request){
        $otp = rand(100000,999999);
        $messageloadtobesent='';
        $usernumber = $request->phonenumber;
        $client = new \GuzzleHttp\Client(); 
        $sentrequest = "https://www.hisms.ws/api.php?send_sms&username=966500253832&password=0919805287&numbers={$usernumber}&sender=khabir&message={$otp}";
        $res = $client->get($sentrequest);
        $result = $res->getBody();
        if (substr($result,0,1) == '3'){
            $messageloadtobesent = 'Message sent!';
        }
        else {
            $messageloadtobesent = 'Message not sent!';
        }
        return response()->json([
            'messagestatus' => $messageloadtobesent,
            'otp' => $otp
        ],200);
    }

    public function uploadprofileimg(Request $request,$id) {
        $user = User::findOrFail($id);
        $filename = $user->username . $user->phonenumber . ".jpg";
        $path = $request->file('photo')->move(public_path("uploads/"),$filename);
        $photoURL = url('uploads/'.$filename);
        return response()->json([
            'url'=> $photoURL
        ],200);
    }

    public function rate(Request $request,$id){
        $rate = 0;$count = 0;$newcount = 0;
        $request->validate([
            'rate'=>'required'
        ]);

        $user = User::findOrFail($id);
        $oldrating = $user->rate;
        $passedrating = $request->rate;
        $token = strtok($oldrating, ",");
        $count = $token;
        $token = strtok(",");
        $rate = $token;
        $newcount = $count + 1;
        $result = $count*$rate;
        $result = $result+$passedrating;
        $result = $result/$newcount;
        $user->rate = $newcount . "," .substr($result,0,4);
        $user->update();
        return response()->json([
            'count'=> $newcount,
            'rate'=> substr($result,0,4)            
        ],200);
    }
}

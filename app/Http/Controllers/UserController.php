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
        $user = $request->isMethod('put') ? User::findOrFail($request->id) : new User;

        //$user->username = $request->input('username');
        if (empty($request->input('username'))) {
            return [
                'Message' => 'username is required.'
            ];
        } else {
            $user->username = $request->input('username');
        }
        //$user->password = $request->input('password');
        if (empty($request->input('password'))) {
            return [
                'Message' => 'password is required.'
            ];
        } else {
            $user->password = $request->input('password');
        }
        //$user->phonenumber = $request->input('phonenumber');
        if (empty($request->input('phonenumber'))) {
            return [
                'Message' => 'phonenumber is required.'
            ];
        } else {
            $user->phonenumber = $request->input('phonenumber');
        }
        $user->profileimg = $request->input('profileimg');
        $user->location = $request->input('location');
        $user->role = $request->input('role');
        $user->rate = $request->input('rate');
        $user->active = $request->input('active');
        $user->serviceproviderid = $request->input('serviceproviderid');
        $user->balance = $request->input('balance');

        if ($user->save()) {
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

        if ($user->delete()) {
            return new UserResource($user);
        }
    }

    public function otpuser(Request $request)
    {
        // $otp = rand(100000, 999999);
        // $messageloadtobesent = '';
        // $usernumber = $request->phonenumber;
        // $client = new \GuzzleHttp\Client();
        // $sentrequest = "https://www.hisms.ws/api.php?send_sms&username=966500253832&password=0919805287&numbers={$usernumber}&sender=khabir&message={$otp}";
        // $res = $client->get($sentrequest);
        // $result = $res->getBody();
        // if (substr($result, 0, 1) == '3') {
        //     $messageloadtobesent = 'Message sent!';
        // } else {
        //     $messageloadtobesent = 'Message not sent!';
        // }
        // return response()->json([
        //     'messagestatus' => $messageloadtobesent,
        //     'otp' => $otp
        // ], 200);

        //

        $otp = rand(100000, 999999);
        $usernumber = $request->phonenumber;
        $client = new \GuzzleHttp\Client();
        $sentrequest = $client->request('POST', 'https://www.msegat.com/gw/sendsms.php', ['body' => [
            'userName' => 'chief20001',
            'numbers' => $usernumber,
            'userSender' => 'khabeer',
            'apiKey' => 'e13b5f6a23a7cc0d392daa2ee155c546',
            'msg' => $otp
        ]]);
        $res = $sentrequest;
        $result = $res->getBody();
        return $result;
    }

    public function uploadprofileimg(Request $request, $id)
    {
        $user = User::findOrFail($id);
        //old upload
        // $filename = $user->id . $user->phonenumber . ".jpg";
        // $path = $request->file('photo')->move(public_path("uploads/"), $filename);
        // $photoURL = url('uploads/' . $filename);
        //new upload
        // $imageName = time() . '.' . $request->photo->getClientOriginalExtension();
        // $request->photo->move(public_path('uploadedphotos'), $imageName);
        // $url = 'http://107.181.170.128/public/uploadedphotos/' . $imageName;
        $avatarName = $user->username . '_avatar' . time() . '.' . request()->photo->getClientOriginalExtension();
        $request->photo->storeAs('/avatars', $avatarName);
        $url = 'http://107.181.170.128/storage/app/avatars/' . $avatarName;
        $user->profileimg = $url;
        $user->save();
        return response()->json([
            'url' => $url
        ], 200);
    }

    public function rate(Request $request, $id)
    {
        $rate = 0;
        $count = 0;
        $newcount = 0;
        $request->validate([
            'rate' => 'required'
        ]);

        $user = User::findOrFail($id);
        $oldrating = $user->rate;
        $passedrating = $request->rate;
        $token = strtok($oldrating, ",");
        $count = $token;
        $token = strtok(",");
        $rate = $token;
        $newcount = $count + 1;
        $result = $count * $rate;
        $result = $result + $passedrating;
        $result = $result / $newcount;
        $user->rate = $newcount . "," . substr($result, 0, 4);
        $user->update();
        return response()->json([
            'count' => $newcount,
            'rate' => substr($result, 0, 4)
        ], 200);
    }

    public function notifyuser(Request $request)
    {

        $client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'key=AAAA_zwre0s:APA91bFD9MhifoGNK0AXJp-ejWTwBpLIFL45xAku_YgaCMp00Wan5CCI1QrqwnmCKGK-DPWDmnqnr0w3L7wmizfmk5r-uloPKx1dgRYpGZ9Xsz3veFF2ZxZ_vI0zSU-DU5qDPNMll1gQ'], ['Content-Type' => 'application/json']]);
        $sentrequest = "https://fcm.googleapis.com/fcm/send";
        $res = $client->post($sentrequest, [
            'json' => [
                'to' => 'dVCcZW0eY_IdQ2FzR6ocfs:APA91bGFMxrCo8_qAYQIeciklIAeLmlSZ_WUsFzbcaxyUPVHNAH0kxZQPNYe6PHTtrAjDimwurQ_elhllJu2zXV_7wVmep8sT1fk1KmT6ekeDk6pMjyYKXWRIrpW4mC9C0IO3pknxgEz',
                'notification' => [
                    'body' => 'inside the app !',
                    'title' => 'Portugal vs. Denmark',
                    'content_available' => true,
                    'priority' => "high"
                ],
                'data' => [
                    'body' => 'inside the app !',
                    'title' => 'Portugal vs. Denmark',
                    'content_available' => true,
                    'priority' => "high"
                ],
            ]
        ]);
        $result = $res->getBody();
        return response()->json([
            'body' => $result
        ], 201);
    }
}

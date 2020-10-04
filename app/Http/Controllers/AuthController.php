<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\ServiceProvidor;
use Hash;

//use DebugBar\DebugBar;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'phonenumber' => 'required|unique:users',
            'notification_token' => 'required'
        ]);
        $user = new User([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'phonenumber' => $request->phonenumber,
            'profileimg' => $request->profileimg,
            'role' => $request->role,
            'code' => $request->code,
            //'active' => $request->$inactive,
            'serviceproviderid' => $request->serviceproviderid,
            'balance' => $request->balance,
            'notification_token' => $request->notification_token
        ]);
        $user->save();
        $user = User::findOrFail($user->id);
        $otp = rand(100000, 999999);
        $messageloadtobesent = '';
        $usernumber = $request->phonenumber;
        // $sentrequest = "https://www.hisms.ws/api.php?send_sms&username=966500253832&password=0919805287&numbers={$usernumber}&sender=khabir&message={$otp}";
        // $res = $client->get($sentrequest);
        // $result = $res->getBody();
        // if (substr($result,0,1) == '3'){
        //     $messageloadtobesent = 'Message sent!';
        // }
        // else {
        //     $messageloadtobesent = 'Message not sent!';
        // }
        $client = new \GuzzleHttp\Client();
        $response = $client->request('post', 'https://www.msegat.com/gw/sendsms.php', [
            'json' => [
                'userName' => 'chief20001',
                'numbers' => $usernumber,
                'userSender' => 'khabeer',
                'apiKey' => 'e13b5f6a23a7cc0d392daa2ee155c546',
                'msg' => $otp
            ]
        ]);
        // echo $response->getBody();
        return response()->json([
            'userstatus' => 'Successfully created user!',
            'messagestatus' => $response->getBody(),
            'otp' => $otp,
            'userid' => $user->id
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->validate([
            'phonenumber' => 'required',
            'password' => 'required',
            'notification_token' => 'required'
        ]);
        $credentials = request(['phonenumber', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $user->notification_token = $request->notification_token;
        $user->save();
        //updating notification token in here
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        //$otp = generateNumericOTP();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'userid' => $user->id,
            'role' => $user->role,
            'active' => $user->active,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    public function adminslogin(Request $request)
    {
        $request->validate([
            'phonenumber' => 'required',
            'password' => 'required'
        ]);
        // get user object
        $user = Admin::where('phonenumber', request()->phonenumber)->first();
        if (!empty($user->phonenumber)) {
            if (!empty($user->password)) {
                if ($request->phonenumber == $user->phonenumber && $request->password == $user->password) {
                    // log the user in (needed for future requests)
                    Auth::login($user);
                    // get new token
                    $tokenResult = $user->createToken('Personal Access Token');
                    $token = $tokenResult->token;
                    $token->save();
                    // return token in json response
                    return response()->json([
                        'access_token' => $tokenResult->accessToken,
                        'token_type' => 'Bearer',
                        'id' => $user->id,
                        'role' => $user->role,
                        'expires_at' => Carbon::parse(
                            $tokenResult->token->expires_at
                        )->toDateTimeString()
                    ]);
                } else {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function serviceprovidorslogin(Request $request)
    {
        $request->validate([
            'phonenumber' => 'required',
            'password' => 'required',
            'notification_token' => 'required'
        ]);
        // get user object
        $user = ServiceProvidor::where('phonenumber', request()->phonenumber)->first();
        if (!empty($user->phonenumber)) {
            if (!empty($user->password)) {
                if ($request->phonenumber == $user->phonenumber && $request->password == $user->password) {
                    // log the user in (needed for future requests)
                    Auth::login($user);
                    $user->notification_token = $request->notification_token;
                    $user->save();
                    // get new token
                    $tokenResult = $user->createToken('Personal Access Token');
                    $token = $tokenResult->token;
                    $token->save();
                    // return token in json response
                    //updating notification token in here
                    return response()->json([
                        'access_token' => $tokenResult->accessToken,
                        'token_type' => 'Bearer',
                        'providerid' => $user->id,
                        'role' => $user->role,
                        'active' => $user->active,
                        'expires_at' => Carbon::parse(
                            $tokenResult->token->expires_at
                        )->toDateTimeString()
                    ]);
                } else {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
            } else {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $user = User::findOrFail($request->id);
        // $request->user()->token()->revoke();
        // $user->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function serviceprovidorlogout(Request $request)
    {
        $providor = ServiceProvidor::findOrFail($request->id);
        // $request->user()->token()->revoke();
        // $user->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function otpuser($id)
    {
        $user = User::findOrFail($id);
        $otp = rand(100000, 999999);
        $usernumber = $user->phonenumber;
        $client = new \GuzzleHttp\Client();
        $response = $client->request('post', 'https://www.msegat.com/gw/sendsms.php', [
            'json' => [
                'userName' => 'chief20001',
                'numbers' => $usernumber,
                'userSender' => 'khabeer',
                'apiKey' => 'e13b5f6a23a7cc0d392daa2ee155c546',
                'msg' => $otp
            ]
        ]);
        $res = $response->getBody();
        return response()->json([
            'messagestatus' => $res,
            'otp' => $otp
        ], 201);
    }
}

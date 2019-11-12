<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;

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
            'username' => 'required|string',
            'password' => 'required|string',
            'phonenumber' => 'required|unique:users',
        ]);
        $user = new User([      
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'phonenumber' => $request->phonenumber,
            'profileimg' => $request->profileimg,
            'role' => $request->role,
            'code' => $request->code,
            'active' => $request->active,
            'serviceproviderid' => $request->serviceproviderid,
            'balance' => $request->balance,
        ]);
        $user->save();

        $otp = rand(100000,999999);
        //$messageloadtobesent='';
        //$usernumber = $request->phonenumber;
        //$client = new \GuzzleHttp\Client(); 
        //$sentrequest = "https://www.hisms.ws/api.php?send_sms&username=966500253832&password=0919805287&numbers={$usernumber}&sender=khabir&message={$otp}";
        //$res = $client->get($sentrequest);
        //$result = $res->getBody();
        //if (substr($result,0,1) == '3'){
        //    $messageloadtobesent = 'Message sent!';
        //}
        //else {
        //    $messageloadtobesent = 'Message not sent!';
        //}
        return response()->json([
            'userstatus' => 'Successfully created user!',
            //'messagestatus' => $messageloadtobesent,
            'otp' => $otp
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
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
        $credentials = request(['username', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        //$otp = generateNumericOTP();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            //'otp' => $otp,
        'role' => $user->role,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
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
}

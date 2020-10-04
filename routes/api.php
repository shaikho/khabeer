<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//this is master banchs
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('adminslogin', 'AuthController@adminslogin');
    Route::post('serviceprovidorslogin', 'AuthController@serviceprovidorslogin');
    Route::post('serviceprovidor', 'ServiceProvidorController@store');
    Route::post('logout', 'AuthController@logout');
    Route::post('serviceprovidorlogin', 'AuthController@serviceprovidorlogout');
});

Route::group(['middleware' => ['auth.admins', 'auth:api']], function () {
});

Route::group(['middleware' => ['auth.serviceprovidors', 'auth:api']], function () {
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', 'AuthController@user');
    Route::get('logout', 'AuthController@logout');
    //subservices
    Route::get('subservices', 'SubServiceController@index');
    Route::get('subservice/{id}', 'SubServiceController@show');
    Route::post('subservice', 'SubServiceController@store');
    Route::put('subservice', 'SubServiceController@store');
    Route::delete('subservice/{id}', 'SubServiceController@destroy');
    Route::get('subservicesbyparent/{id}', 'SubServiceController@filteredsubservices');
    //services
    Route::get('services', 'ServiceController@index');
    Route::get('service/{id}', 'ServiceController@show');
    Route::post('service', 'ServiceController@store');
    Route::put('service', 'ServiceController@store');
    Route::delete('service/{id}', 'ServiceController@destroy');
    //servicesprovidors
    Route::get('serviceprovidors', 'ServiceProvidorController@index');
    Route::get('serviceprovidor/{id}', 'ServiceProvidorController@show');
    Route::post('serviceprovidor', 'ServiceProvidorController@store');
    Route::put('serviceprovidor', 'ServiceProvidorController@store');
    Route::delete('serviceprovidor/{id}', 'ServiceProvidorController@destroy');
    Route::post('rateserviceprovidor/{id}', 'ServiceProvidorController@rate');
    Route::post('filterprovidors', 'ServiceProvidorController@filterserviceprovidors');
    Route::post('addcredit', 'ServiceProvidorController@addcredit');
    Route::post('subcredit', 'ServiceProvidorController@substractcredit');
    //requests
    Route::get('requests', 'RequestController@index');
    Route::get('request/{id}', 'RequestController@show');
    Route::post('request', 'RequestController@store');
    Route::put('request', 'RequestController@store');
    Route::delete('request/{id}', 'RequestController@destroy');
    Route::get('userrequests/{id}', 'RequestController@requestsbyuser');
    Route::get('providerrequests/{id}', 'RequestController@requestsbyprovider');
    Route::post('filterrequests', 'RequestController@filterrequests');
    Route::post('filterrequestsbytwo', 'RequestController@filterrequestsbytwo');
    Route::get('getliverequests', 'RequestController@getliverequests');

    //users
    Route::get('users', 'UserController@index');
    Route::get('user/{id}', 'UserController@show');
    Route::post('user', 'UserController@store');
    Route::put('user', 'UserController@store');

    Route::delete('user/{id}', 'UserController@destroy');
    //Route::get('otpuser', 'UserController@otpuser');
    Route::post('rateuser/{id}', 'UserController@rate');
    Route::post('notifyuser', 'UserController@notifyuser');
    //admins
    Route::get('admins', 'AdminController@index');
    Route::get('admin/{id}', 'AdminController@show');
    Route::post('admin', 'AdminController@store');
    Route::put('admin', 'AdminController@store');
    Route::delete('admin/{id}', 'AdminController@destroy');
    Route::post('iconsupload/{id}', 'AdminController@uploadicon');
    //violations
    Route::get('violations', 'ViolationController@index');
    Route::get('violation/{id}', 'ViolationController@show');
    Route::post('violation', 'ViolationController@store');
    Route::put('violation', 'ViolationController@store');
    Route::delete('violation/{id}', 'ViolationController@destroy');
    Route::get('violationsbyprovidor/{id}', 'ViolationController@violationsbyprovidor');
    Route::get('violationsbyuser/{id}', 'ViolationController@violationsbyuser');
    //summary
    Route::get('summary', 'ViolationController@summary');
    Route::post('scheduled', 'RequestController@scheduled');
    Route::get('allscheduled', 'RequestController@allscheduledrequestes');
});
//trmp
Route::post('ahmed', 'RequestController@filterrequests');
Route::post('filterrequests', 'RequestController@filterrequests');
Route::get('user', 'AuthController@user');
Route::post('logout', 'AuthController@logout');
//subservices
Route::get('subservices', 'SubServiceController@index');
Route::get('subservice/{id}', 'SubServiceController@show');
Route::post('subservice', 'SubServiceController@store');
Route::put('subservice', 'SubServiceController@store');
Route::delete('subservice/{id}', 'SubServiceController@destroy');
Route::get('subservicesbyparent/{id}', 'SubServiceController@filteredsubservices');
//services
Route::get('services', 'ServiceController@index');
Route::get('service/{id}', 'ServiceController@show');
Route::post('service', 'ServiceController@store');
Route::put('service', 'ServiceController@store');
Route::delete('service/{id}', 'ServiceController@destroy');
//servicesprovidors
Route::get('serviceprovidors', 'ServiceProvidorController@index');
Route::get('serviceprovidor/{id}', 'ServiceProvidorController@show');
Route::post('serviceprovidor', 'ServiceProvidorController@store');
Route::put('serviceprovidor', 'ServiceProvidorController@store');
Route::delete('serviceprovidor/{id}', 'ServiceProvidorController@destroy');
Route::post('rateserviceprovidor/{id}', 'ServiceProvidorController@rate');
Route::post('filterprovidors', 'ServiceProvidorController@filterserviceprovidors');
Route::post('addcredit', 'ServiceProvidorController@addcredit');
Route::post('subcredit', 'ServiceProvidorController@substractcredit');
//requests
Route::get('requests', 'RequestController@index');
Route::get('request/{id}', 'RequestController@show');
Route::post('request', 'RequestController@store');
Route::put('request', 'RequestController@store');
Route::delete('request/{id}', 'RequestController@destroy');
Route::get('userrequests/{id}', 'RequestController@requestsbyuser');
Route::get('providerrequests/{id}', 'RequestController@requestsbyprovider');
Route::post('filterrequests', 'RequestController@filterrequests');
Route::post('filterrequestsbytwo', 'RequestController@filterrequestsbytwo');
Route::get('getliverequests', 'RequestController@getliverequests');

//users
Route::get('users', 'UserController@index');
Route::get('user/{id}', 'UserController@show');
Route::post('user', 'UserController@store');
Route::put('user', 'UserController@store');
Route::put('updateActivity', 'UserController@updateActivity'); // ahmed 
Route::delete('user/{id}', 'UserController@destroy');
//Route::post('otpuser', 'UserController@otpuser');
Route::post('rateuser/{id}', 'UserController@rate');
Route::post('notifyuser', 'UserController@notifyuser');
//admins
Route::get('admins', 'AdminController@index');
Route::get('admin/{id}', 'AdminController@show');
Route::post('admin', 'AdminController@store');
Route::put('admin', 'AdminController@store');
Route::delete('admin/{id}', 'AdminController@destroy');
Route::post('iconsupload/{id}', 'AdminController@uploadicon');
//violations
Route::get('violations', 'ViolationController@index');
Route::get('violation/{id}', 'ViolationController@show');
Route::post('violation', 'ViolationController@store');
Route::put('violation', 'ViolationController@store');
Route::delete('violation/{id}', 'ViolationController@destroy');
Route::get('violationsbyprovidor/{id}', 'ViolationController@violationsbyprovidor');
Route::get('violationsbyuser/{id}', 'ViolationController@violationsbyuser');
//summary
Route::get('summary', 'ViolationController@summary');
Route::post('scheduled', 'RequestController@scheduled');
Route::get('allscheduled', 'RequestController@allscheduledrequestes');
//
Route::post('uploadprovidorprofileimg/{id}', 'ServiceProvidorController@uploadprofileimg');
Route::post('uploaduserprofileimg/{id}', 'UserController@uploadprofileimg');
Route::post('uploadadminprofileimg/{id}', 'AdminController@uploadprofileimg');
Route::post('getrequestsbydistance', 'RequestController@requestsbydistance');
//
Route::post('otpuser/{id}', 'AuthController@otpuser');


Route::post('smstest', function () {
    $otp = rand(100000, 999999);
    $client = new \GuzzleHttp\Client();
    $response = $client->request('post', 'https://www.msegat.com/gw/sendsms.php', [
        'json' => [
            'userName' => 'chief20001',
            'numbers' => '966538215687',
            'userSender' => 'khabeer',
            'apiKey' => 'e13b5f6a23a7cc0d392daa2ee155c546',
            'msg' => 'efweferf'
        ]
    ]);
    return $response->getBody();
    // $res = $client->post('https://www.msegat.com/gw/sendsms.php', [
    //     'json' => [
    //         'userName' => 'chief20001',
    //         'numbers' => '966539115751',
    //         'userSender' => 'khabeer',
    //         'apiKey' => 'e13b5f6a23a7cc0d392daa2ee155c546',
    //         'msg' => 'this is a test'
    //     ]
    // ]);
});

Route::post('upload', function (Request $request) {

    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $avatarName = '_avatar' . time() . '.' . request()->photo->getClientOriginalExtension();
    $request->photo->storeAs('/avatars', $avatarName);
    $url = 'http://107.181.170.128/storage/app/avatars/' . $avatarName;
    return response()->json([
        'url' => $url
    ]);
});

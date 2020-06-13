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
    Route::post('uploadprovidorprofileimg/{id}', 'ServiceProvidorController@uploadprofileimg');
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
    Route::get('otpuser', 'UserController@otpuser');
    Route::post('uploaduserprofileimg/{id}', 'UserController@uploadprofileimg');
    Route::post('rateuser/{id}', 'UserController@rate');
    Route::post('notifyuser', 'UserController@notifyuser');
    //admins
    Route::get('admins', 'AdminController@index');
    Route::get('admin/{id}', 'AdminController@show');
    Route::post('admin', 'AdminController@store');
    Route::put('admin', 'AdminController@store');
    Route::delete('admin/{id}', 'AdminController@destroy');
    Route::post('uploadadminprofileimg/{id}', 'AdminController@uploadprofileimg');
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

Route::get('test', function () {
    $temp = '966565119873';
    $otp = rand(100000, 999999);
    echo $sentrequest = "https://www.hisms.ws/api.php?send_sms&username=966500253832&password=0919805287&numbers={$temp}&sender=khabir&message={$otp}";
    $client = new \GuzzleHttp\Client();
    $res = $client->get($sentrequest);
    $result = $res->getBody();
    echo $result;
});

Route::post('upload', function (Request $request) {

    $imageName = time() . '.' . $request->input_img->getClientOriginalExtension();
    $request->input_img->move(public_path('uploadedphotos'), $imageName);
    $url = 'http://localhost/public/uploadedphotos/' . $imageName;
    //http://107.181.170.128/public/uploads/1125.jpg
    return response()->json([
        'url' => $url
    ], 200);
});

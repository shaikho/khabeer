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

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('adminslogin', 'AuthController@adminslogin');
    Route::post('serviceprovidorslogin', 'AuthController@serviceprovidorslogin');
});

Route::group(['middleware' => ['auth.admins','auth:api']], function() {

});

Route::group(['middleware' => ['auth.serviceprovidors','auth:api']], function() {

});

Route::group(['middleware' => 'auth:api'], function() {
      Route::get('user', 'AuthController@user');
      Route::get('logout', 'AuthController@logout');
      //subservices
      Route::get('subservices','SubServiceController@index');
      Route::get('subservice/{id}','SubServiceController@show');
      Route::post('subservice','SubServiceController@store');
      Route::put('subservice','SubServiceController@store');
      Route::delete('subservice/{id}','SubServiceController@destroy');
      Route::get('subservicesbyparent/{id}','SubServiceController@filteredsubservices');
      //services
      Route::get('services','ServiceController@index');
      Route::get('service/{id}','ServiceController@show');
      Route::post('service','ServiceController@store');
      Route::put('service','ServiceController@store');
      Route::delete('service/{id}','ServiceController@destroy');
      //servicesprovidors
      Route::get('serviceprovidors','ServiceProvidorController@index');
      Route::get('serviceprovidor/{id}','ServiceProvidorController@show');
      Route::post('serviceprovidor','ServiceProvidorController@store');
      Route::put('serviceprovidor','ServiceProvidorController@store');
      Route::delete('serviceprovidor/{id}','ServiceProvidorController@destroy');
      Route::post('rateserviceprovidor/{id}','ServiceProvidorController@rate');
      //requests
      Route::get('requests','RequestController@index');
      Route::get('request/{id}','RequestController@show');
      Route::post('request','RequestController@store');
      Route::put('request','RequestController@store');
      Route::delete('request/{id}','RequestController@destroy');
      Route::get('userrequests/{id}','RequestController@requestsbyuser');
      Route::get('providerrequests/{id}','RequestController@requestsbyprovider');
      Route::post('filterrequests','RequestController@filterrequests');
      Route::post('filterrequestsbytwo','RequestController@filterrequestsbytwo');
      //users
      Route::get('users','UserController@index');
      Route::get('user/{id}','UserController@show');
      Route::post('user','UserController@store');
      Route::put('user','UserController@store');
      Route::delete('user/{id}','UserController@destroy');
      Route::get('otpuser','UserController@otpuser');
      Route::post('uploadprofileimg/{id}','UserController@uploadprofileimg');
      //admins
      Route::get('admins','AdminController@index');
      Route::get('admin/{id}','AdminController@show');
      Route::post('admin','AdminController@store');
      Route::put('admin','AdminController@store');
      Route::delete('admin/{id}','AdminController@destroy');
      //testing
  });

  Route::get('test', function(){
    $temp = '966565119873'; $otp = rand(100000,999999);
    echo $sentrequest = "https://www.hisms.ws/api.php?send_sms&username=966500253832&password=0919805287&numbers={$temp}&sender=khabir&message={$otp}";
    $client = new \GuzzleHttp\Client(); 
    $res = $client->get($sentrequest);
    $result = $res->getBody();
    echo $result;
});
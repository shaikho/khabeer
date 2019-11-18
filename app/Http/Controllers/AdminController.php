<?php

namespace App\Http\Controllers;

use Log;
use Illuminate\Http\Request;
use App\Admin;
use App\Http\Resources\AdminResource;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::All();
        return new AdminResource($admin);
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
        Log::debug(is_array($request->subno));
        $admin = $request->isMethod('put') ? Admin::findOrFail
        ($request->id) : new Admin;
        
        if (empty($request->input('username'))) {
            return [
                'Message'=>'username is required.'
            ];
        }
        else {
            $admin->username = $request->input('username');
        }
        if (empty($request->input('password'))) {
            return [
                'Message'=>'password is required.'
            ];
        }
        else {
            $admin->password = $request->input('password');
        }
        //$admin->phonenumber = $request->input('phonenumber');
        if (empty($request->input('phonenumber'))) {
            return [
                'Message'=>'phonenumber is required.'
            ];
        }
        else {
            $admin->phonenumber = $request->input('phonenumber');
        }
        //$admin->role = $request->input('role');
        if (empty($request->input('role'))) {
            return [
                'Message'=>'role is required.'
            ];
        }
        else {
            $admin->role = $request->input('role');
        }
        //$admin->area = $request->input('area');
        if (empty($request->input('area'))) {
            return [
                'Message'=>'area is required.'
            ];
        }
        else {
            $admin->area = $request->input('area');
        }

        if($admin->save()){
            return new AdminResource($admin);
        }
        $admin->profileimg = $request->input('profileimg');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $admin = Admin::findOrFail($id);
        return new AdminResource($admin);
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
        $admin = Admin::findOrFail($id);

        if($admin->delete()){
            return new ServiceResource($admin);
        }
    }

    public function uploadprofileimg(Request $request,$id) {
        $user = Admin::findOrFail($id);
        $filename = $user->username . $user->phonenumber . ".jpg";
        $path = $request->file('photo')->move(public_path("uploads/"),$filename);
        $photoURL = url('uploads/'.$filename);
        return response()->json([
            'url'=> $photoURL
        ],200);
    }
}

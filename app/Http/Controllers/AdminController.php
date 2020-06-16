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
        // $request->validate([
        //     'phonenumber' => 'required|string|unique:admins',
        //     'password' => 'required|string'
        // ]);

        // $admin = $request->isMethod('put') ? Admin::findOrFail
        // ($request->id) : new Admin;

        if ($request->isMethod('put')) {

            $request->validate([
                'id' => 'required'
            ]);

            $admin = Admin::findOrFail($request->id);

            if (!empty($request->input('username'))) {
                $admin->username = $request->input('username');
            }
            if (!empty($request->input('password'))) {
                $admin->password = $request->input('password');
            }
            if (!empty($request->input('phonenumber'))) {
                $admin->phonenumber = $request->input('phonenumber');
            }
            if (!empty($request->input('profileimg'))) {
                $admin->profileimg = $request->input('profileimg');
            }
            if (!empty($request->input('role'))) {
                $admin->role = $request->input('role');
            }
            if (!empty($request->input('area'))) {
                $admin->area = $request->input('area');
            }

            if ($admin->save()) {
                return new AdminResource($admin);
            }
        }

        $admin = new Admin;

        if (empty($request->input('username'))) {
            return [
                'Message' => 'username is required.'
            ];
        } else {
            $admin->username = $request->input('username');
        }
        if (empty($request->input('password'))) {
            return [
                'Message' => 'password is required.'
            ];
        } else {
            $admin->password = $request->input('password');
        }
        //$admin->phonenumber = $request->input('phonenumber');
        if (empty($request->input('phonenumber'))) {
            return [
                'Message' => 'phonenumber is required.'
            ];
        } else {
            $admin->phonenumber = $request->input('phonenumber');
        }
        //$admin->role = $request->input('role');
        if (empty($request->input('role'))) {
            return [
                'Message' => 'role is required.'
            ];
        } else {
            $admin->role = $request->input('role');
        }
        //$admin->area = $request->input('area');
        if (empty($request->input('area'))) {
            return [
                'Message' => 'area is required.'
            ];
        } else {
            $admin->area = $request->input('area');
        }
        $admin->profileimg = $request->input('profileimg');

        if ($admin->save()) {
            return new AdminResource($admin);
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

        if ($admin->delete()) {
            return new AdminResource($admin);
        }
    }

    public function uploadprofileimg(Request $request, $id)
    {
        $user = Admin::findOrFail($id);
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

    public function uploadicon(Request $request, $id)
    {
        $filename = $id . ".jpg";
        $path = $request->file('photo')->move(public_path("uploads/"), $filename);
        $photoURL = url('uploads/' . $filename);
        return response()->json([
            'url' => $photoURL
        ], 200);
    }
}

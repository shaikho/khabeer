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
        if ($request->isMethod('put')) {

            $request->validate([
                'id' => 'required'
            ]);

            $serviceprovider = ServiceProvidor::findOrFail($request->id);
            if (!empty($request->input('username'))) {
                $serviceprovider->username = $request->input('username');
            }
            if (!empty($request->input('phonenumber'))) {
                $serviceprovider->phonenumber = $request->input('phonenumber');
            }
            if (!empty($request->input('password'))) {
                $serviceprovider->password = $request->input('password');
            }
            if (!empty($request->input('buildingno'))) {
                $serviceprovider->buildingno = $request->input('buildingno');
            }
            if (!empty($request->input('unitno'))) {
                $serviceprovider->unitno = $request->input('unitno');
            }
            if (!empty($request->input('docs'))) {
                $serviceprovider->docs = $request->input('docs');
            }
            if (!empty($request->input('profileimg'))) {
                $serviceprovider->profileimg = $request->input('profileimg');
            }
            if (!empty($request->input('role'))) {
                $serviceprovider->role = $request->input('role');
            }
            if (!empty($request->input('postalcode'))) {
                $serviceprovider->postalcode = $request->input('postalcode');
            }
            if (!empty($request->input('neighborhood'))) {
                $serviceprovider->neighborhood = $request->input('neighborhood');
            }
            if (!empty($request->input('nationalid'))) {
                $serviceprovider->nationalid = $request->input('nationalid');
            }
            if (!empty($request->input('nationaladdress'))) {
                $serviceprovider->nationaladdress = $request->input('nationaladdress');
            }
            if (!empty($request->input('rate'))) {
                $serviceprovider->rate = $request->input('rate');
            }
            if (!empty($request->input('clients'))) {
                $serviceprovider->clients = $request->input('clients');
            }
            if (!empty($request->input('type'))) {
                $serviceprovider->type = $request->input('type');
            }
            if (!empty($request->input('approved'))) {
                $serviceprovider->approved = $request->input('approved');
            }
            if (!empty($request->input('code'))) {
                $serviceprovider->code = $request->input('code');
            }
            if (!empty($request->input('active'))) {
                $serviceprovider->active = $request->input('active');
            }
            if (!empty($request->input('requestid'))) {
                $serviceprovider->requestid = $request->input('requestid');
            }
            if (!empty($request->input('subserviceid'))) {
                $serviceprovider->subserviceid = $request->input('subserviceid');
            }
            if (!empty($request->input('credit'))) {
                $serviceprovider->credit = $request->input('credit');
            }
            if (!empty($request->input('notification_token'))) {
                $serviceprovider->notification_token = $request->input('notification_token');
            }
            if ($serviceprovider->save()) {
                return new ServiceProvidorResource($serviceprovider);
            }
        }

        $request->validate([
            'phonenumber' => 'required|unique:service_providors',
            'password' => 'required'
        ]);

        $serviceprovider = new ServiceProvidor;

        //$serviceprovider->username = $request->input('username');
        if (!empty($request->input('username'))) {
            $serviceprovider->username = $request->input('username');
        } else {
            return [
                'Message' => 'username is required.'
            ];
        }
        //$serviceprovider->phonenumber = $request->input('phonenumber');
        if (!empty($request->input('phonenumber'))) {
            $serviceprovider->phonenumber = $request->input('phonenumber');
        } else {
            return [
                'Message' => 'phonenumber is required.'
            ];
        }
        //$serviceprovider->password = $request->input('password');
        if (!empty($request->input('password'))) {
            $serviceprovider->password = $request->input('password');
        } else {
            return [
                'Message' => 'password is required.'
            ];
        }

        if (!empty($request->input('notification_token'))) {
            $serviceprovider->notification_token = $request->input('notification_token');
        } else {
            $serviceprovider->notification_token = '';
            //this should be removed
            // return [
            //     'Message'=>'notification_token is required.'
            // ];
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
        if (!empty($request->input('credit'))) {
            $serviceprovider->credit = $request->input('credit');
        } else {
            $serviceprovider->credit = '0';
        }
        $serviceprovider->subserviceid = $request->input('subserviceid');

        if ($serviceprovider->save()) {
            return new ServiceProvidorResource($serviceprovider);
        }
    }

    /**
     * Display the specified resource.
     *
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

        if ($serviceprovider->delete()) {
            return new ServiceProvidorResource($serviceprovider);
        }
    }

    public function rate(Request $request, $id)
    {
        $rate = 0;
        $count = 0;
        $newcount = 0;
        $request->validate([
            'rate' => 'required'
        ]);

        $serviceprovider = ServiceProvidor::findOrFail($id);
        $oldrating = $serviceprovider->rate;
        $passedrating = $request->rate;
        $token = strtok($oldrating, ",");
        $count = $token;
        $token = strtok(",");
        $rate = $token;
        $newcount = $count + 1;
        $result = $count * $rate;
        $result = $result + $passedrating;
        $result = $result / $newcount;
        $serviceprovider->rate = $newcount . "," . substr($result, 0, 4);
        $serviceprovider->update();
        return response()->json([
            'count' => $newcount,
            'rate' => substr($result, 0, 4)
        ], 200);
    }

    public function uploadprofileimg(Request $request, $id)
    {
        $user = ServiceProvidor::findOrFail($id);
        //old upload
        // $filename = $user->id . $user->phonenumber . ".jpg";
        // $path = $request->file('photo')->move(public_path("uploads/"), $filename);
        // $photoURL = url('uploads/' . $filename);
        //new upload updated
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

    public function filterserviceprovidors(Request $request)
    {
        $request->validate([
            'filter' => 'required',
            'key' => 'required'
        ]);

        $requests = ServiceProvidor::where($request->filter, $request->key)->get(['id', 'username', 'phonenumber', 'password', 'buildingno', 'unitno', 'docs', 'profileimg', 'role', 'postalcode', 'neighborhood', 'nationalid', 'nationaladdress', 'rate', 'clients', 'type', 'approved', 'code', 'active', 'requestid', 'subserviceid', 'credit', 'notification_token', 'created_at', 'updated_at']);
        return new ServiceProvidorResource($requests);
    }

    public function addcredit(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'amount' => 'required'
        ]);

        $serviceprovider = ServiceProvidor::findOrFail($request->id);
        $providorcredit = (int) $serviceprovider->credit;
        $amount = $request->amount;
        $sum = $providorcredit + $amount;
        $serviceprovider->credit = (string) $sum;
        $serviceprovider->save();

        return response()->json([
            'Message' => 'creadit added.'
        ], 200);
    }

    public function substractcredit(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'amount' => 'required'
        ]);

        $serviceprovider = ServiceProvidor::findOrFail($request->id);
        $providorcredit = (int) $serviceprovider->credit;
        $amount = $request->amount;
        if ($amount <= $providorcredit) {
            $sum = $providorcredit - $amount;
        } else {
            return response()->json([
                'Message' => 'Providor credit is not sufficient.'
            ], 200);
        }
        $serviceprovider->credit = (string) $sum;
        $serviceprovider->save();

        return response()->json([
            'Message' => 'Creadit Substracted.'
        ], 200);
    }
}

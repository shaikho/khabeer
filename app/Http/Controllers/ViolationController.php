<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestResource;
use App\Http\Resources\ViolationResource;
use Illuminate\Http\Request;
use App\Violation;
use App\User;
use App\ServiceProvidor;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\RM;
use App\Admin;


class ViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $violations = Violation::All();

        $filteredviolations = [];
        foreach($violations as $violation){
            $violation->providername = 'N/A';
            $violation->customername = 'N/A';
            $violation->adminname = 'N/A';

            $serviceprovider = ServiceProvidor::find($violation->providor_id);
            $user = User::find($violation->user_id);
            $admin = Admin::find($violation->admin_id);

            if(!empty($serviceprovider->username)){
                $violation->providername = $serviceprovider->username;
            }
            if(!empty($user->username)){
                $violation->customername = $user->username;
            }
            if(!empty($admin->username)){
                $violation->adminname = $admin->username;
            }
            array_push($filteredviolations, $violation);
        }

        return new ViolationResource($violations);
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
        $violation = $request->isMethod('put') ? Violation::findOrFail
        ($request->id) : new Violation();
        
        if (empty($request->input('user_id'))) {
            return [
                'Message'=>'user_id is required.'
            ];
        }
        else {
            $violation->user_id = $request->input('user_id');
        }
        //$service->servicenamearabic = $request->input('servicenamearabic');
        if (empty($request->input('providor_id'))) {
            return [
                'Message'=>'providor_id is required.'
            ];
        }
        else {
            $violation->providor_id = $request->input('providor_id');
        }
        //$service->description = $request->input('description');
        if (empty($request->input('admin_id'))) {
            return [
                'Message'=>'admin_id is required.'
            ];
        }
        else {
            $violation->admin_id = $request->input('admin_id');
        }
        if (empty($request->input('level'))) {
            return [
                'Message'=>'level is required.'
            ];
        }
        else {
            $violation->level = $request->input('level');
        }
        if (empty($request->input('credit'))) {
            return [
                'Message'=>'credit is required.'
            ];
        }
        else {
            $violation->credit = $request->input('credit');
        }
        if (empty($request->input('datetime'))) {
            return [
                'Message'=>'datetime is required.'
            ];
        }
        else {
            $violation->datetime = $request->input('datetime');
        }
        $violation->notes = $request->input('notes');

        if($violation->save()){
            return new ViolationResource($violation);
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
        $violation = Violation::findOrFail($id);
        $serviceprovidor = ServiceProvidor::findOrFail($violation->providor_id);
        $customer = User::findOrFail($violation->user_id);
        return response()->json([
            'data' => $violation,
            'providername' => $serviceprovidor->username,
            'customername' => $customer->username
        ],200);
        //return new ViolationResource($violation);

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
        $violation = Violation::findOrFail($id);

        if($violation->delete()){
            return new ViolationResource($violation);
        }
    }

    public function summary(){
        $userscount = DB::table('users')->count();
        $requestscount = DB::table('r_m_s')->count();
        $serviceprovidorscount = DB::table('service_providors')->count();
        $servicescount = DB::table('services')->count();
        $subservicescount = DB::table('sub_services')->count();
        $requests = RM::orderBy ('startdate', 'DESC')->get();
        $requests = $requests->take(15);
        $filteredrequests = [];
        foreach($requests as $request){
            if ($request->status == "submitted"){
                $request->providorname = 'N/A';
                $request->customername = 'N/A';

                $serviceprovider = ServiceProvidor::find($request->providerid);
                $user = User::find($request->userid);

                if(!empty($serviceprovider->username)){
                    $request->providorname = $serviceprovider->username;
                }
                if(!empty($user->username)){    
                    $request->customername = $user->username;
                }
                array_push($filteredrequests, $request);
            }
        }
        return response()->json([
            'userscount' => $userscount,
            'requestscount' => $requestscount,
            'serviceprovidorscount' => $serviceprovidorscount,
            'servicescount' => $servicescount,
            'subservicescount' => $subservicescount,
            'requests' => $filteredrequests
        ],200);
    }

    public function violationsbyprovidor(int $id){
        
        $violations = Violation::where('providor_id', $id)->get(['id','user_id', 'providor_id','admin_id','level','credit','notes','datetime','created_at','updated_at']);

        $providor = 'N/A';
        $customer = 'N/A';

        $serviceprovider = ServiceProvidor::find($id);

        if(!empty($serviceprovider->username)){
            $providor = $serviceprovider->username;
        }
        
        return response()->json([
            'data' => $violations,
            'providor' => $providor
        ]);
        //return new ViolationResource($violations);
    }

    public function violationsbyuser(int $id){
        
        $violations = Violation::where('user_id', $id)->get(['id','user_id', 'providor_id','admin_id','level','credit','notes','datetime','created_at','updated_at']);

        $providor = 'N/A';
        $customer = 'N/A';

        $user = User::find($id);

        if(!empty($user->username)){
            $customer = $user->username;
        }
        //return new ViolationResource($violations);
    }

}

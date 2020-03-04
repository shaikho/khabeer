<?php

namespace App\Http\Controllers;

use App\Http\Resources\ViolationResource;
use Illuminate\Http\Request;
use App\Violation;
use App\User;
use App\ServiceProvidor;

class ViolationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $violation = Violation::All();
        // $serviceprovidor = ServiceProvidor::findOrFail($violation->providor_id);
        // $customer = User::findOrFail($violation->user_id);
        // return response()->json([
        //     'data' => $violation,
            // 'providername' => $serviceprovidor->username,
            // 'customername' => $customer->username
        // ],200);
        return new ViolationResource($violation);
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
}

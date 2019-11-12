<?php

namespace App\Http\Controllers;


use App\Http\Requsts;
use App\RM;
use Illuminate\Http\Request;
use App\Http\Resources\RequestResource as RequestResource;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $req = RM::All();
        return RequestResource::collection($req);
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
        $req = $request->isMethod('put') ? RM::findOrFail
        ($request->id) : new RM;

        //$req->id = $request->input('id');
        $req->subno = $request->input('subno');
        $req->subserviceprice = $request->input('subserviceprice');
        $req->subservicename = $request->input('subservicename');
        $req->subservicearabicname = $request->input('subservicearabicname');
        $req->enddate = $request->input('enddate');
        $req->userid = $request->input('userid');
        $req->providerid = $request->input('providerid');
        $req->subserviceslug = $request->input('subserviceslug');
        $req->cancelled = $request->input('cancelled');
        $req->location = $request->input('location');
        $req->cancelmessage = $request->input('cancelmessage');
        $req->status = $request->input('status');
        $req->user_lang = $request->input('user_lang');
        $req->userauth = $request->input('userauth');
        $req->providorlang = $request->input('providorlang');
        $req->providorauth = $request->input('providorauth');

        if($req->save()){
            return new RequestResource($req);
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
        $req = RM::findOrFail($id);
        return new RequestResource($req);
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
        $req = RM::findOrFail($id);

        if ($req->delete()){
            return new RequestResource($req);
        }
    }
}

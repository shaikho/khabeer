<?php

namespace App\Http\Controllers;

use App\Events\JobRequest;
use App\Http\Requsts;
use App\RM;
use DB;
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
        $req = $request->isMethod('put') ?
        RM::findOrFail($request->id) : new RM;
        
        // if($request->isMethod('put')){
        //     $req = RM::find($request);
        // }
        
        //$req->subno = $request->input('subno');
        if (!empty($request->input('subno'))) {
            $req->subno = $request->input('subno');
        }
        else {
            return [
                'Message'=>'subno is required.'
            ];
        }
        //$req->subserviceprice = $request->input('subserviceprice');
        if (!empty($request->input('subserviceprice'))) {
            $req->subserviceprice = $request->input('subserviceprice');
        }
        else {
            return [
                'Message'=>'subserviceprice is required.'
            ];
        }
        //$req->subservicename = $request->input('subservicename');
        if (!empty($request->input('subservicename'))) {
            $req->subservicename = $request->input('subservicename');
        }
        else {
            return [
                'Message'=>'subservicename is required.'
            ];
        }
        //$req->enddate = $request->input('enddate');
        if (!empty($request->input('enddate'))) {
            $req->enddate = $request->input('enddate');
        }
        else {
            return [
                'Message'=>'enddate is required.'
            ];
        }
        //$req->subservicearabicname = $request->input('subservicearabicname');
        if (!empty($request->input('subservicearabicname'))) {
            $req->subservicearabicname = $request->input('subservicearabicname');
        }
        else {
            return [
                'Message'=>'subservicearabicname is required.'
            ];
        }
        //$req->userid = $request->input('userid');
        if (!empty($request->input('userid'))) {
            $req->userid = $request->input('userid');
        }
        else {
            return [
                'Message'=>'userid is required.'
            ];
        }
        //$req->providerid = $request->input('');
        if (!empty($request->input('providerid'))) {
            $req->providerid = $request->input('providerid');
        }
        else {
            return [
                'Message'=>'providerid is required.'
            ];
        }
        $req->subserviceslug = $request->input('subserviceslug');
        $req->cancelled = $request->input('cancelled');
        $req->cancelmessage = $request->input('cancelmessage');
        $req->status = $request->input('status');
        $req->user_lang = $request->input('user_lang');
        $req->userauth = $request->input('userauth');
        $req->providorlang = $request->input('providorlang');
        $req->providorauth = $request->input('providorauth');
        $req->location = $request->input('location');

        //event(new JobRequest($req));

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

    public function requestsbyuser($id){
        $requests = RM::where('userid', $id)->get(['id','subno', 'subserviceprice','subservicename','subservicearabicname','enddate','userid','providerid','location','subserviceslug','cancelled','cancelmessage','status','user_lang','userauth','providorlang','providorauth','created_at','updated_at']);
        return new RequestResource($requests);
    }

    public function requestsbyprovider($id){
        $requests = RM::where('providerid', $id)->get(['id','subno', 'subserviceprice','subservicename','subservicearabicname','enddate','userid','providerid','location','subserviceslug','cancelled','cancelmessage','status','user_lang','userauth','providorlang','providorauth','created_at','updated_at']);
        return new RequestResource($requests);
    }

    public function filterrequests(Request $request){
        $request->validate([
            'filter' => 'required',
            'key' => 'required'
        ]);

        //$requests = RM::where($request->filter, $request->key)->get(['id','subno', 'subserviceprice','subservicename','subservicearabicname','enddate','userid','providerid','location','subserviceslug','cancelled','cancelmessage','status','user_lang','userauth','providorlang','providorauth','created_at','updated_at']);
        $requests = DB::table('r_m_s')
        ->select('r_m_s.id','r_m_s.subno', 'r_m_s.subserviceprice','r_m_s.subservicename','r_m_s.subservicearabicname','r_m_s.enddate','r_m_s.userid','r_m_s.providerid','r_m_s.location','r_m_s.subserviceslug','r_m_s.cancelled','r_m_s.cancelmessage','r_m_s.status','r_m_s.user_lang','r_m_s.userauth','r_m_s.providorlang','r_m_s.providorauth','r_m_s.created_at','r_m_s.updated_at','sub_services.iconurl')
        ->join('sub_services','sub_services.id','=','r_m_s.subno');
        
        return new RequestResource($requests);
    }

    public function filterrequestsbytwo(Request $request){
        $request->validate([
            'filter' => 'required',
            'key' => 'required',
            'alsofilter' => 'required',
            'alsokey' => 'required'
        ]);
        
        $requests = RM::where($request->filter, $request->key)->where($request->alsofilter,$request->alsokey)->get(['id','subno', 'subserviceprice','subservicename','subservicearabicname','enddate','userid','providerid','location','subserviceslug','cancelled','cancelmessage','status','user_lang','userauth','providorlang','providorauth','created_at','updated_at']);
        return new RequestResource($requests);
    }
}

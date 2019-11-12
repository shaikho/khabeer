<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubServiceResource;
use Illuminate\Http\Request;
use App\SubService;

class SubServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subservice = Subservice::All();
        return new SubServiceResource($subservice);
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
        $subservice = $request->isMethod('put') ? Subservice::findOrFail
        ($request->id) : new SubService;

        //$subservice->id = $request->input('id');
        $subservice->subservicename = $request->input('subservicename');
        $subservice->subservicenamearabic = $request->input('subservicenamearabic');
        $subservice->price = $request->input('price');
        $subservice->status = $request->input('status');
        $subservice->slug = $request->input('slug');
        $subservice->description = $request->input('description');
        $subservice->descriptionarabic = $request->input('descriptionarabic');
        $subservice->iconurl = $request->input('iconurl');
        $subservice->serviceid = $request->input('serviceid');

        if($subservice->save()){
            return new SubServiceResource($subservice);
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
        $subservice = SubService::findOrFail($id);
        return new SubServiceResource($subservice);
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
        $subservice = SubService::findOrFail($id);

        if($subservice->delete()){
            return new SubServiceResource($subservice);
        }
    }

    public function filteredsubservices($id){
        //$subservices = SubService::find($id, ['subservicename', 'subservicenamearabic','price','status','slug','description','descriptionarabic','serviceid','created_at','update_at']);
        //$subservices = SubService::all(['subservicename'])->toArray();
        //$subservices = SubService::where('serviceid',$id)->get(['subservicename', 'subservicenamearabic','price','status','slug','description','descriptionarabic','serviceid','created_at','update_at'])->toArray();
        //$subservices = SubService::find($id, ['subservicename', 'subservicenamearabic','price','status','slug','description','descriptionarabic','serviceid','created_at','update_at']);
        //$subservices = SubService::all(['serviceid'])->toArray();
        //$subservices = SubService::where('serviceid', $id)->pluck('subservicename', 'subservicenamearabic','price','status','slug','description','descriptionarabic','serviceid','created_at','update_at')->all();
        $subservices = SubService::where('serviceid', $id)->get(['subservicename', 'subservicenamearabic','price','status','slug','description','descriptionarabic','serviceid','created_at','updated_at']);
        return new SubServiceResource($subservices);
    }
}

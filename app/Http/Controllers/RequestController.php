<?php

namespace App\Http\Controllers;

use App\Events\JobRequest;
use App\Http\Requsts;
use App\RM;
use App\User;
use DB;
use Illuminate\Http\Request;
use App\Http\Resources\RequestResource as RequestResource;
use App\ServiceProvidor;
use DateTime;
use Carbon\Carbon;


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

        $filteredrequests = [];
        foreach ($req as $request) {
            $request->providorname = 'N/A';
            $request->customername = 'N/A';

            $serviceprovider = ServiceProvidor::find($request->providerid);
            $user = User::find($request->userid);

            if (!empty($serviceprovider->username)) {
                $request->providorname = $serviceprovider->username;
            }
            if (!empty($user->username)) {
                $request->customername = $user->username;
            }

            array_push($filteredrequests, $request);
        }
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
        } else {
            return [
                'Message' => 'subno is required.'
            ];
        }
        //$req->subserviceprice = $request->input('subserviceprice');
        if (!empty($request->input('subserviceprice'))) {
            $req->subserviceprice = $request->input('subserviceprice');
        } else {
            return [
                'Message' => 'subserviceprice is required.'
            ];
        }
        //$req->subservicename = $request->input('subservicename');
        if (!empty($request->input('subservicename'))) {
            $req->subservicename = $request->input('subservicename');
        } else {
            return [
                'Message' => 'subservicename is required.'
            ];
        }
        //$req->enddate = $request->input('enddate');
        if (!empty($request->input('enddate'))) {
            $req->enddate = $request->input('enddate');
        } else {
            return [
                'Message' => 'enddate is required.'
            ];
        }
        //$req->subservicearabicname = $request->input('subservicearabicname');
        if (!empty($request->input('subservicearabicname'))) {
            $req->subservicearabicname = $request->input('subservicearabicname');
        } else {
            return [
                'Message' => 'subservicearabicname is required.'
            ];
        }
        //$req->userid = $request->input('userid');
        if (!empty($request->input('userid'))) {
            $req->userid = $request->input('userid');
        } else {
            return [
                'Message' => 'userid is required.'
            ];
        }
        //$req->providerid = $request->input('');
        if (!empty($request->input('providerid'))) {
            $req->providerid = $request->input('providerid');
        } else {
            return [
                'Message' => 'providerid is required.'
            ];
        }
        if (!empty($request->input('startdate'))) {
            $req->startdate = $request->input('startdate');
        } else {
            return [
                'Message' => 'startdate is required.'
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

        //getting user id and update statuses
        if ($request->status == 'approved') {
            $title = 'Your request has been approved';
            $body = 'Your requested service has been accepted by service provider ';
            $this->pushnotificationtocustomer($request->userid, $request->providerid, $title, $body);
        } else if ($request->status == 'finished') {
            $title = 'Your request has been completed';
            $body = 'Required payment is  ' . $request->subserviceprive . ' thank you for using our services';
            $this->pushnotificationtocustomer($request->userid, $request->providerid, $title, $body);
        } else if ($request->status == 'payed') {
            $title = 'Job completed';
            $body = 'Job completed Successfully thank you ';
            $this->pushnotificationtoprovider($request->userid, $request->providerid, $title, $body);
        }
        //

        if ($req->save()) {
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

        $req->providor = 'N/A';
        $req->customer = 'N/A';

        $serviceprovider = ServiceProvidor::find($req->providerid);
        $user = User::find($req->userid);

        if (!empty($serviceprovider->username)) {
            $req->providor = $serviceprovider->username;
        }
        if (!empty($user->username)) {
            $req->customer = $user->username;
        }



        // if(!empty($req->providerid)){
        //     // if(ServiceProvidor::findOrFail($req->providerid)){
        //     //     $serviceprovider = ServiceProvidor::findOrFail($req->providerid);
        //     //     $providor = $serviceprovider->username;
        //     // }else{
        //     //     $providor = 'N/A';
        //     // }
        //     $serviceprovider = ServiceProvidor::find($req->providerid);
        //     if()
        //     $providor = $serviceprovider->username;
        // }

        // if(!empty($req->userid)){
        //     $user = User::findOrFail($req->userid);
        //     $customer = $user->username;
        // }

        return new RequestResource($req);
        // return response()->json([
        //     'data' => new RequestResource($req),
        //     'providorname' => $providor,
        //     'customername' => $customer
        // ], 200);

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

        $providor = 'N/A';
        $customer = 'N/A';

        if ($req->providerid != null) {
            $serviceprovider = ServiceProvidor::findOrFail($req->providerid);
            $providor = $serviceprovider->username;
        }

        if ($req->userid != null) {
            $user = User::findOrFail($req->userid);
            $customer = $user->username;
        }

        if ($req->delete()) {

            return response()->json([
                'data' => new RequestResource($req),
                'providorname' => $providor,
                'customername' => $customer
            ], 200);
        }

        // if ($req->delete()){
        //     return new RequestResource($req);
        // }
    }

    public function requestsbyuser($id)
    {
        $requests = RM::where('userid', $id)->get(['id', 'subno', 'subserviceprice', 'subservicename', 'subservicearabicname', 'startdate', 'enddate', 'userid', 'providerid', 'location', 'subserviceslug', 'cancelled', 'cancelmessage', 'status', 'user_lang', 'userauth', 'providorlang', 'providorauth', 'created_at', 'updated_at']);
        $filterrequests = [];
        foreach($requests as $request){

            $request->serviceprovidername = 'N/A';
            $request->customername = 'N/A';

            $serviceprovider = ServiceProvidor::find($request->providerid);
            $user = User::find($request->userid);

            if(!empty($serviceprovider->username)){
                $request->serviceprovidername = $serviceprovider->username;
            }
            if(!empty($user->username)){
                $request->customername = $user->username;
            }

            array_push($filterrequests,$request);

        }
        return new RequestResource($requests);
    }

    public function requestsbyprovider($id)
    {
        $requests = RM::where('providerid', $id)->get(['id', 'subno', 'subserviceprice', 'subservicename', 'subservicearabicname', 'startdate', 'enddate', 'userid', 'providerid', 'location', 'subserviceslug', 'cancelled', 'cancelmessage', 'status', 'user_lang', 'userauth', 'providorlang', 'providorauth', 'created_at', 'updated_at']);
        $filterrequests = [];
        foreach($requests as $request){

            $request->serviceprovidername = 'N/A';
            $request->customername = 'N/A';

            $serviceprovider = ServiceProvidor::find($request->providerid);
            $user = User::find($request->userid);

            if(!empty($serviceprovider->username)){
                $request->serviceprovidername = $serviceprovider->username;
            }
            if(!empty($user->username)){
                $request->customername = $user->username;
            }

            array_push($filterrequests,$request);

        }
        return new RequestResource($requests);
    }

    public function filterrequests(Request $request)
    {
        $request->validate([
            'filter' => 'required',
            'key' => 'required'
        ]);

        $requests = RM::where($request->filter, $request->key)->get(['id', 'subno', 'subserviceprice', 'subservicename', 'subservicearabicname', 'startdate', 'enddate', 'userid', 'providerid', 'location', 'subserviceslug', 'cancelled', 'cancelmessage', 'status', 'user_lang', 'userauth', 'providorlang', 'providorauth', 'created_at', 'updated_at']);
        // $requests = DB::table('r_m_s')
        // ->select('r_m_s.id','r_m_s.subno', 'r_m_s.subserviceprice','r_m_s.subservicename','r_m_s.subservicearabicname','r_m_s.enddate','r_m_s.userid','r_m_s.providerid','r_m_s.location','r_m_s.subserviceslug','r_m_s.cancelled','r_m_s.cancelmessage','r_m_s.status','r_m_s.user_lang','r_m_s.userauth','r_m_s.providorlang','r_m_s.providorauth','r_m_s.created_at','r_m_s.updated_at','sub_services.iconurl')
        // ->join('sub_services','sub_services.id','=','r_m_s.subno');

        return new RequestResource($requests);
    }

    public function filterrequestsbytwo(Request $request)
    {
        $request->validate([
            'filter' => 'required',
            'key' => 'required',
            'alsofilter' => 'required',
            'alsokey' => 'required'
        ]);

        $requests = RM::where($request->filter, $request->key)->where($request->alsofilter, $request->alsokey)->get(['id', 'subno', 'subserviceprice', 'subservicename', 'subservicearabicname', 'startdate', 'enddate', 'userid', 'providerid', 'location', 'subserviceslug', 'cancelled', 'cancelmessage', 'status', 'user_lang', 'userauth', 'providorlang', 'providorauth', 'created_at', 'updated_at']);
        return new RequestResource($requests);
    }

    public function pushnotificationtocustomer(string $userid, string $providerid, string $title, string $body)
    {
        $user = User::findOrFail($userid);
        $serviceprovider = ServiceProvidor::findOrFail($providerid);
        $client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'key=AAAA_zwre0s:APA91bFD9MhifoGNK0AXJp-ejWTwBpLIFL45xAku_YgaCMp00Wan5CCI1QrqwnmCKGK-DPWDmnqnr0w3L7wmizfmk5r-uloPKx1dgRYpGZ9Xsz3veFF2ZxZ_vI0zSU-DU5qDPNMll1gQ'], ['Content-Type' => 'application/json']]);
        $sentrequest = "https://fcm.googleapis.com/fcm/send";
        $res = $client->post($sentrequest, [
            'json' => [
                'to' => $user->notification_token,
                'notification' => [
                    'body' => $body . $serviceprovider->username,
                    'title' => $title,
                    'content_available' => true,
                    'priority' => 'high'
                ],
                'data' => [
                    'body' => $body . $serviceprovider->username,
                    'title' => $title,
                    'content_available' => true,
                    'priority' => 'high'
                ],
            ]
        ]);
    }

    public function pushnotificationtoprovider(string $userid, string $providerid, string $title, string $body)
    {
        $user = User::findOrFail($userid);
        $serviceprovider = ServiceProvidor::findOrFail($providerid);
        $client = new \GuzzleHttp\Client(['headers' => ['Authorization' => 'key=AAAA_zwre0s:APA91bFD9MhifoGNK0AXJp-ejWTwBpLIFL45xAku_YgaCMp00Wan5CCI1QrqwnmCKGK-DPWDmnqnr0w3L7wmizfmk5r-uloPKx1dgRYpGZ9Xsz3veFF2ZxZ_vI0zSU-DU5qDPNMll1gQ'], ['Content-Type' => 'application/json']]);
        $sentrequest = "https://fcm.googleapis.com/fcm/send";
        $res = $client->post($sentrequest, [
            'json' => [
                'to' => $user->notification_token,
                'notification' => [
                    'body' => $body . $serviceprovider->username . 'for your service',
                    'title' => $title,
                    'content_available' => true,
                    'priority' => 'high'
                ],
                'data' => [
                    'body' => $body . $serviceprovider->username . 'for your service',
                    'title' => $title,
                    'content_available' => true,
                    'priority' => 'high'
                ],
            ]
        ]);
    }

    public function getliverequests(Request $request)
    {
        $requests = RM::where('startdate', 'NOW')->get(['id', 'subno', 'subserviceprice', 'subservicename', 'subservicearabicname', 'startdate', 'enddate', 'userid', 'providerid', 'location', 'subserviceslug', 'cancelled', 'cancelmessage', 'status', 'user_lang', 'userauth', 'providorlang', 'providorauth', 'created_at', 'updated_at']);
        return new RequestResource($requests);
    }

    public function scheduled(Request $request)
    {

        $request->validate([
            'id' => 'required'
        ]);

        $datetimenow = new DateTime();
        $datetimenow = $datetimenow->format('Y-m-d H:i:s');
        $datetimenow = date('Y-m-d H:i:s');

        $req = RM::findOrFail($request->id);
        $date = $req->startdate;

        if ($date > $datetimenow) {
            $req->providor = 'N/A';
            $req->customer = 'N/A';

            if ($req->providerid != null) {
                $serviceprovider = ServiceProvidor::findOrFail($req->providerid);
                $req->providor = $serviceprovider->username;
            }

            if ($req->userid != null) {
                $user = User::findOrFail($req->userid);
                $req->customer = $user->username;
            }

            return new RequestResource($req);
            // return response()->json([
            //     'data' => new RequestResource($req),
            //     'providorname' => $providor,
            //     'customername' => $customer
            // ], 200);
        } else {
            return response()->json([
                'data' => 'not scheduled request'
            ]);
        }
    }

    public function allscheduledrequestes()
    {

        $requests = RM::whereDate('startdate', '>=', Carbon::now()->toDateString())->get();

        return response()->json([
            'data' => $requests
        ]);

        // $datetimenow = new DateTime();
        // $datetimenow = $datetimenow->format('Y-m-d H:i:s');
        // $datetimenow = date('Y-m-d H:i:s');

        // $requests = RM::whereDate('startdate','>',$datetimenow);
        // return response()->json([
        //     'data' => $requests
        // ]);
        //return new RequestResource($requests);
        // $requests = RM::All();

        // foreach($requests as $request){
        //     $date = $request->startdate;
        //     if($date > $datetimenow){
        //     }
        // }
    }
}

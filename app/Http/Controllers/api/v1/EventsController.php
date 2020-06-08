<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userDetails = auth()->user();

        $events = Event::where('user_id', $userDetails['id'])
        ->where('flag', 1)
        ->orderBy('name', 'asc')
        ->get();
        
        if(count($events) > 0) {
            $dataArray['code'] = 1;
            $dataArray['message'] = "success";
            $dataArray['data'] = $events;
        } else {
            $dataArray['code'] = 0;
            $dataArray['message'] = "failed";
            $dataArray['data'] = null;
        }
        
        // return csrf_token(); 
        return json_encode($dataArray);
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
        $this->validate($request,[
            'user_id' => 'required',
            'name' => 'required',
            'duration' => 'required'
        ]);

        $event = new Event;
        $event->user_id = $request->input('user_id');
        $event->name = $request->input('name');
        $event->duration = $request->input('duration');
        $event->created_at = date('Y-m-d H:i:s');
        $event->updated_at = date('Y-m-d H:i:s');

        if($event->save()) {
            $dataArray['code'] = 1;
            $dataArray['message'] = "success";
        } else {
            $dataArray['code'] = 0;
            $dataArray['message'] = "failed";
        }
        
        return json_encode($dataArray);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::check()) {
            $dataArray['code'] = 0;
            $dataArray['message'] = "failed";
            $dataArray['error'] = 'UnAuthorised';
            return response()->json($dataArray, 401);
        }

        $event = Event::find($id);

        if($event) {
            $dataArray['code'] = 1;
            $dataArray['message'] = "success";
            $dataArray['data'] = $event;
        } else {
            $dataArray['code'] = 0;
            $dataArray['message'] = "failed";
            $dataArray['data'] = null;
        }

        return json_encode($dataArray);
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
        //
    }
}
<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Event;
use DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userDetails = auth()->user();

        $schedules = Schedule::with('event')
        ->where('user_id', $userDetails['id'])
        ->orderBy('call_timestamp', 'desc')
        ->get();

        $events = Event::where('user_id', $userDetails['id'])
        ->where('flag', 1)
        ->orderBy('created_at', 'desc')
        ->get();

        // dd($schedules);
                
        foreach ($schedules as $key => $value) {

            if(strtotime(date('y-m-d H:i:s')) < strtotime($value['call_timestamp'])) {
                $dateType = 'upcoming';
            } else {
                $dateType = 'past';
            }

            $data['data']['schedules'][$dateType][strtotime($value['call_date'])][strtotime($value['call_timestamp'])] = array(
                'name' => $value['caller_fname'] .' '.$value['caller_lname'],
                'type' => $value->event['name'],
                'scheduleTime' => $value->event['duration'],
                'call_timestamp' => $value['call_timestamp'],
                'call_date' => date('l, d M Y', strtotime($value['call_date'])),
                'call_time' => $value['call_time'],
                'humanTiming' => humanTiming(strtotime($value['call_timestamp']))
            );

            $data['data']['schedule_dates'][$dateType][strtotime($value['call_date'])] = array(
                'scheDates' => date('l, d M Y', strtotime($value['call_date']))
            );

            ksort($data['data']['schedules'][$dateType]);
            ksort($data['data']['schedule_dates'][$dateType]);

            // $data['data']['schedules'][$dateType] = array_values($data['data']['schedules'][$dateType])
            ;    
            // $data['data']['schedules'][$dateType] = array_values_recursive($data['data']['schedule_dates'][$dateType]);    
            
        }

        if(count($events) > 0) {
            $data['data']['type'] = $events;
        }

        
        
        if(count($schedules) > 0 || count($events) > 0) {
            $dataArray['code'] = 1;
            $dataArray['message'] = "success";
            $dataArray['data'] = $data['data'];
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
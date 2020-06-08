<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use DB;

class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = 1;

        $schedules = Schedule::with('event')
        ->where('user_id', $userId)
        ->orderBy('call_timestamp', 'desc')
        ->get();

        // dd($schedules);
                
        foreach ($schedules as $key => $value) {

            $dataArray['data'][] = array(
                'name' => $value['caller_fname'] .' '.$value['caller_lname'],
                'type' => $value->event['name'],
                'scheduleTime' => $value->event['duration'],
                'call_timestamp' => $value['call_timestamp'],
                'call_date' => $value['call_date'],
                'call_time' => $value['call_time'],
                'humanTiming' => $this->humanTiming(strtotime($value['call_timestamp']))
            );

        }
        
        if(count($schedules) > 0) {
            $dataArray['code'] = 1;
            $dataArray['message'] = "success";
            $dataArray['data'] = $dataArray['data'];
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

    public function humanTiming ($time) {

        $timestamp = $time;	
   
        $strTime = array("second", "minute", "hour", "day", "month", "year");
        $length = array("60","60","24","30","12","10");

        $currentTime = time();
        if($currentTime >= $timestamp) {
                $diff = time()- $timestamp;
                for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
                $diff = $diff / $length[$i];
                }

                $diff = round($diff);
                return $diff . " " . $strTime[$i] . "(s) ago ";
        } else {
            $diff = $timestamp-time();
            for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
            $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return "Time remaining: ".$diff . " " . $strTime[$i] . "(s)";
        }

    }
}
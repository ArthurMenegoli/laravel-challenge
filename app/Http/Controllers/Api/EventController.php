<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Event;

class EventController extends Controller
{
    public function index() {
        $events = Event::all();
        return response()->json($events);
    }
    
    public function store(Request $request) {

        try {
            $event = new Event();
            $event->title = $request->title;
            $event->description = $request->description;
            $event->begin_date = $request->begin_date;
            $event->close_date = $request->close_date;
            
            $event->save();

            return ['returne' => 'Evento criado com sucesso!'];
        } 
        catch (\Exception $erro) {
            return ['returne'=> 'erro', 'details'=>dd($erro)];
        }
    
    }

    public function todayEvents() {
        $currentDay = date('Y-m-d');
        
        $events = Event::all();
        $arrEvents = array();
        foreach($events as $event){
            if((strtotime($event->begin_date) == strtotime($currentDay))){
                $arrEvents[] = $event;
            }
        }
        return response()->json($arrEvents);
    }

    public function upcomingEvents() {
        $currentDay = date('Y-m-d');
        $nextFiveDays = date('Y-m-d', strtotime('+5 days'));
        
        $events = Event::all();
        $arrEvents = array();
        foreach($events as $event){
            if((strtotime($event->begin_date) <= strtotime($nextFiveDays) && (strtotime($event->begin_date) >= strtotime($currentDay)))){
                $arrEvents[] = $event;
            }
        }
        return response()->json($arrEvents);
    }
}
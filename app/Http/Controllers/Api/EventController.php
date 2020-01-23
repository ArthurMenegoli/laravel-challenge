<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Event;

use Validator;

class EventController extends Controller
{
    public function index() {
        $events = Event::all();
        return response()->json($events);
    }
    
    public function store(Request $request) {

        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required|max:191',
            'description' => 'required',
            'begin_date' => 'required',
            'close_date' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'message' => 'Há campos sem preenchimento!',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        $event = new Event();
        $event->fill($data);
        $event->save();

        return response([$event,
            'message' => 'O evento foi criado com sucesso!'
        ], 200);
            
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

    public function update(Request $request, $id) {

        $event = Event::find($id);

        if(!$event){
            return respose()->json(['message' => 'Não existem registro desse evento.'], 404);
        }
        else {
            echo($event->fill($request->all()));
            $event->save();
    
            return response()->json($event);
        }
        
    }

    public function destroy ($id) {
        $event = Event::find($id);

        if(!$event){
            return response()->json(['message' => 'Não existem registro desse evento.'], 404);
        }
        else {
            $event->delete();

            return response()->json(['message' => 'Evento removido com sucesso!'], 200);
        }
    }
}
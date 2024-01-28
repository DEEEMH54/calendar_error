<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class bookingController extends Controller
{
    public function index()
    {
        $event = array();
        $bookings = Booking::all();
        foreach ($bookings as $booking) {
            $event[] = [
                'id'   => $booking->id,
                'title' => $booking->title_booking,
                'start' => $booking->start_time_booking,
                'end' => $booking->end_time_booking,
                'room'=> $booking->room_booking
                //'color' => $color
            ];
        }
        //return $event;
        return view('calendar', ['event' => $event]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'room'=>'required'
        ]);
        $booking=Booking::create([
            'title_booking' => $request->title,
            'start_time_booking' => $request->start_date,
            'end_time_booking' => $request->end_date,
            'room_booking' =>$request->room,
        ]);
        return response()->json($booking);
        return redirect()->route('calendar')->with('success', 'Booking created successfully.');
    
    }
    public function update(Request $request,$id){
        $booking11=Booking::find($id);
        if(! $booking11){
        return response()->json(['error'=>'unable to locate the event'],404);
        }
        $booking11 ->update([
            'title_booking' => $request->title,
            'start_time_booking'=>$request->start,
            'end_time_booking' => $request->end,
            'room_booking' => $request->room,
        ]);
    
       return response()->json('event update');
    }
}

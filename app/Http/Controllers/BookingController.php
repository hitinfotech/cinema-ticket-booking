<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;
use Validator;
use Mail;

class BookingController extends Controller{

    public function index(Request $request){
    	$data['today_booked'] = array_column(Booking::select(['seat_id'])->where('booking_date', date("Y-m-d"))->get()->toArray(),'seat_id');

    	return view('welcome', $data);
    }

    public function booknow(Request $request){
    	$data = $request->all();
        $json = array();

        $rules = array(
			'name'  => 'required|min:3|max:255',
			'email' => 'required|email',
			'mobile' => 'required|min:9',
        );

        $validator = Validator::make($data, $rules);
        if ($validator->fails()){
            $json['errors'] =  api_error_format($validator->errors()->messages());
        } else{
        	$alreadyBooked = Booking::where(['seat_id' => $data['seat_id'], 'booking_date' => date("Y-m-d")])->count();

        	if($alreadyBooked == 0){
	        	$booking = new Booking();
				$booking->seat_id = $data['seat_id'];
				$booking->name    = $data['name'];
				$booking->email   = $data['email'];
				$booking->mobile  = $data['mobile'];
				$booking->booking_date  = date("Y-m-d");
				$booking->save();

				$data['booking_number'] = $booking->id;

				try {
					Mail::send('mails.booking', $data, function($message) use($data) {
			         	$message->to($data['email'], 'Tutorials Point')->subject('Your ticket booked successfully.');
			      	});
		        } catch (\Exception $e) {
		            $json['mail_error'] = $e->getMessage();
		        }

				$json['success'] = 'Ticket booked successfully..!';
        	} else {
        		$json['warning'] = 'This seat is already booked..';
        	}
        }

        return response()->json($json);
    }

    public function cancelbooking(Request $request){
    	$booking = Booking::where(['seat_id' => $request->seat_id])->first();

    	if($booking){
    		$booking->delete();
    		$json['success'] = 'Booking cancelled successfully';
    	} else {
    		$json['warning'] = 'Booking not found..!';
    	}

    	return response()->json($json);
    }
}
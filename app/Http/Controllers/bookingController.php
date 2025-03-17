<?php

namespace App\Http\Controllers;

use App\Events\BookingCreated;
use App\Models\Booking;
use App\Models\BookingDetail;
use Illuminate\Http\Request;

class bookingController extends Controller
{
    public function CreateBooking(Request $request)
    {
        try{
            $RequestBooking=$request->all();
            $Booking=Booking::create(
                [
                    'user_id'=>$RequestBooking['user_id'],
                    'total_book'=>$RequestBooking['total_book'],
                    'status'=>$RequestBooking['status'],
                    'return_date'=>now()->addDays(10),
                    'overdue_status'=>$RequestBooking['overdue_status'],
                ]
            );
            $BookArray=$RequestBooking['book'];
            foreach ($BookArray as $Book) {
                $BookingDetail=BookingDetail::create(
                    [
                        'booking_id'=>$Booking->id,
                        'book_id'=>$Book['book_id'],
                        'amount'=>$Book['amount'],
                    ]
                );
            }
            event(new BookingCreated($Booking));
            return response()->json([
               'status'=>true,
               'booking'=>$Booking->id,
               'message'=>'Booking Successfully Created'
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'message'=>$exception->getMessage()
            ]);
        }




    }
}

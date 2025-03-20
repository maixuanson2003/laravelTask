<?php

namespace App\Http\Controllers;

use App\Events\BookingCreated;
use App\Exceptions\UserException;
use App\Http\Resources\BookingResource;
use App\Jobs\BookingJob;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;

class bookingController extends Controller
{
    public function CreateBooking(Request $request)
    {
        try{
            $RequestBooking=$request->all();
            $user=User::query()->where('id',$RequestBooking['user_id'])->first();
            if($user==null){
                throw new UserException();
            }
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
    public function CreateNewBooking(Request $request){
        try{
            $RequestBooking=$request->all();
            $user=User::query()->where('id',$RequestBooking['user_id'])->first();
            if($user==null){
                $data=new IncomingEntry(
                    [
                        "message"=>"khong co nguoi dung",
                        "type"=>'info'
                    ]);

                Telescope::recordLog($data);
                throw new UserException();
            }
            $Booking=[
                    'user_id'=>$RequestBooking['user_id'],
                    'total_book'=>$RequestBooking['total_book'],
                    'status'=>$RequestBooking['status'],
                    'return_date'=>now()->addDays(10),
                    'overdue_status'=>$RequestBooking['overdue_status'],
                ];

            $BookArray=$RequestBooking['book'];
            BookingJob::dispatch($Booking,$BookArray);
            event(new BookingCreated($Booking));
            return response()->json([
                'status'=>true,
                'message'=>'Booking Successfully Created'
            ]);
        }catch (\Exception $exception){
            $message=$exception->getMessage();


            return response()->json([
                'message'=>$exception->getMessage()
            ]);
        }
    }
    public function GetBookingByUser($UserId){
        echo $UserId;
        $user=User::with("Bookings")->find($UserId);
        $BookingResponse=[];
        $BookingArray=$user->Bookings;
        foreach ($BookingArray as $Booking) {
            $Booking=Booking::with("bookingDetails")->find($Booking->id);
            $BookingResponse[]=new BookingResource($Booking);
        }
        return response()->json([
            'data'=>$BookingResponse,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Events\BookingCreated;
use App\Exceptions\UserException;
use App\Exports\BookingExport;
use App\Http\Resources\BookingResource;
use App\Jobs\BookingJob;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\User;
use App\Service\BookingService;
use App\Service\BookService;
use App\Service\IbookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Maatwebsite\Excel\Excel;

class bookingController extends Controller
{
    protected $bookingService;
    public function __construct(IbookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }
    public function CreateBooking(Request $request)
    {
        try{
            $RequestBooking=$request->all();
            $Booking=$this->bookingService->CreateBooking($RequestBooking);
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
        $BookingResponse=$this->bookingService->GetBookingByUser($UserId);
        return response()->json([
            'data'=>$BookingResponse,
        ]);
    }
    public function GetAmountBookingByDay(Request $request){
        try {
            $date=$request->query('date');
            $startOfDay = Carbon::parse($date)->startOfDay(); // 00:00:00
            $endOfDay = Carbon::parse($date)->endOfDay();
            $amount=$this->bookingService->GetAmountBookingByDay($date);
            return response()->json([
                'data'=>$amount,
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'message'=>$exception->getMessage()

            ]);
        }

    }
    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new BookingExport, 'booking.xlsx');
    }
}

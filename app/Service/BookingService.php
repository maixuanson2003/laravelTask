<?php


namespace App\Service;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Repository\BookingDetailRepository;
use App\Repository\BookingRepository;
use App\Repository\UserRepository;
use Carbon\Carbon;
use Exception;

class BookingService implements  IbookingService
{
    protected $bookingRepository;
    protected $bookingDetailRepository;
    protected $userRepository;
    public  function __construct(BookingRepository $bookingRepositorys,BookingDetailRepository $bookingDetailRepositorys,UserRepository $userRepositorys)
    {
        $this->bookingRepository = $bookingRepositorys;
        $this->bookingDetailRepository = $bookingDetailRepositorys;
        $this->userRepository = $userRepositorys;
    }

    public function CreateBooking($BookingData)
    {
        $user=$this->userRepository->findUserById($BookingData['user_id']);
        if(!$user){
            throw new Exception("User not found");
        }
        $BookingSave=[
            'user_id'=>$BookingData['user_id'],
            'total_book'=>$BookingData['total_book'],
            'status'=>$BookingData['status'],
            'return_date'=>now()->addDays(10),
            'overdue_status'=>$BookingData['overdue_status'],
        ];
        $NewBooking=$this->bookingRepository->create($BookingSave);
        $BookArray=$BookingData['book'];
        foreach ($BookArray as $Book) {
            $BookingDetail= [
                    'booking_id'=>$NewBooking->id,
                    'book_id'=>$Book['book_id'],
                    'amount'=>$Book['amount'],
                ];
            $this->bookingDetailRepository->create($BookingDetail);
        }
        return $NewBooking;
    }



    public function GetBookingByUser($UserId)
    {
        $User=$this->userRepository->findUserById($UserId);
        if(!$User){
            throw new Exception("User not found");
        }
        $BookingResponse=[];
        $BookingArray=$User->Bookings;
        foreach ($BookingArray as $Booking) {
            $Booking=Booking::with("bookingDetails")->find($Booking->id);
            $BookingResponse[]=new BookingResource($Booking);
        }
        return $BookingResponse;
    }

    public function GetAmountBookingByDay($date)
    {
        $startOfDay = Carbon::parse($date)->startOfDay();
        $endOfDay = Carbon::parse($date)->endOfDay();
        $booking=$this->bookingRepository->QueryByDate($startOfDay,$endOfDay);
        return count($booking);
    }
}


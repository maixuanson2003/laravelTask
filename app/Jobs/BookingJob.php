<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Models\BookingDetail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class BookingJob implements ShouldQueue
{
    use Queueable;

    protected $booking;
    protected $bookArray;
    public function __construct($booking, $bookArray)
    {
        $this->booking = $booking;
        $this->bookArray = $bookArray;
    }

    public function handle(): void
    {
        $bookings=Booking::create($this->booking);
        foreach ($this->bookArray as $Book) {
            $BookingDetail=BookingDetail::create(
                [
                    'booking_id'=>$bookings->id,
                    'book_id'=>$Book['book_id'],
                    'amount'=>$Book['amount'],
                ]
            );
        }
    }
}

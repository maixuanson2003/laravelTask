<?php

namespace App\Service;

interface IbookingService
{

    public function CreateBooking( $BookingData);
    public function GetBookingByUser($UserId);

    public function GetAmountBookingByDay($date);
}

<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Database\Eloquent\Collection
     */
    public function collection()
    {
        return Booking::with('bookingDetails')->get(); // Lấy toàn bộ booking kèm theo chi tiết
    }

    public function headings(): array
    {
        return ["Booking ID", "User", "Book ID", "Amount"];
    }

    public function map($booking): array
    {
        $data = [];
        foreach ($booking->bookingDetails as $detail) {
            $data[] = [
                $booking->id,
                $booking->user->name ?? 'N/A', // Nếu có quan hệ user
                $detail->book_id,
                $detail->amount
            ];
        }
        return $data;
    }
}

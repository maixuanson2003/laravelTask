<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        echo $this->bookingDetails;
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'total_book'=>$this->total_book,
            'status'=>$this->status,
            'return_date'   =>Carbon::parse($this->return_date)->format('Y-m-d'),
            'overdue'       => $this->overdue_status,
            'book'=>$this->bookingDetails ? $this->bookingDetails->map(fn($item)=> [
                'id'=>$item->booking_id,
                'book_id'=>$item->book_id,
                'amount'=>$item->amount,
            ]):[]
        ];
    }
}

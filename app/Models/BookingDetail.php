<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingDetail extends Model
{
    use HasFactory;

    protected $table = 'bookingdetails';
    protected $fillable = [
        'booking_id',
        'book_id',
        'amount'
    ];
    public function bookking():BelongsTo
    {
        return $this->belongsTo(Booking::class);

    }
    public function book():BelongsTo
    {
        return $this->belongsTo(BooK::class);

    }
}

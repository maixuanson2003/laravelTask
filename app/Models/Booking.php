<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_book',
        'return_date',
        'status',
        'overdue_status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function bookingDetails() :HasMany
    {
        return $this->hasMany(BookingDetail::class);
    }
}

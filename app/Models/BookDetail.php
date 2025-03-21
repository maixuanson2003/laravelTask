<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookDetail extends Model
{
    protected $table = 'bookdetails';
    protected $fillable = [
        'book_id',
        'Day_set',
        'amount_set',
    ];
    public function book(): BelongsTo{
        return $this->belongsTo(Book::class);
    }
}

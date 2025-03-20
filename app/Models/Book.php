<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'create_year',
        'amount',
    ];
    public function bookDetails(): HasMany{
        return $this->hasMany(BookDetail::class);
    }

}

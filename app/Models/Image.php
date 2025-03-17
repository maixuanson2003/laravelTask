<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $table = 'image';
    protected $fillable = [
        'user_id',
        'url',
    ];
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
}

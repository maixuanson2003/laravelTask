<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function Product(): HasMany{
        return $this->hasMany(Product::class);
    }
    public function Bookings(): HasMany
    {
        return $this->hasMany(Booking::class);

    }
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    public function Image(): HasMany
    {
        return $this->hasMany(Image::class);

    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected function checkAttribute(): Attribute
    {
        return Attribute::make(
            get: fn () => strtoupper($this->name), // Convert name to uppercase
        );
    }
    protected function name(): Attribute
    {
        return Attribute::make(
            set:fn($value) => strtoupper($value),
        );

    }
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => bcrypt($value), // Hash password before saving
        );
    }
}

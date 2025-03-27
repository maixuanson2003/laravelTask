<?php

namespace App\Repository;

use App\Models\Booking;

class BookingRepository
{
    /**
     * Get all bookings.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return Booking::all();
    }
    public function findById(int $id): ?Booking
    {
        return Booking::find($id);
    }
    public function QueryByDate($start,$end)
    {
        return Booking::query()->whereBetween('created_at',[$start,$end])->get();
    }
    public function create(array $data): Booking
    {
        return Booking::create($data);
    }
    public function update(int $id, array $data): bool
    {
        $booking = $this->findById($id);

        if (!$booking) {
            return false;
        }

        return $booking->update($data);
    }
    public function delete(int $id): bool
    {
        $booking = $this->findById($id);

        if (!$booking) {
            return false;
        }

        return $booking->delete();
    }
}

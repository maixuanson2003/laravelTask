<?php

namespace App\Repository;

use App\Models\BookingDetail;

class BookingDetailRepository
{

    public function getAll()
    {
        return BookingDetail::all();
    }
    public function findById(int $id)
    {
        return BookingDetail::find($id);
    }
    public function create($BookDetail)
    {
        return BookingDetail::create($BookDetail);
    }


    public function update(int $id, array $attributes)
    {
        $bookingDetail = $this->findById($id);

        if ($bookingDetail) {
            return $bookingDetail->update($attributes);
        }

        return false;
    }


    public function delete(int $id)
    {
        $bookingDetail = $this->findById($id);

        if ($bookingDetail) {
            return $bookingDetail->delete();
        }

        return false;
    }
}

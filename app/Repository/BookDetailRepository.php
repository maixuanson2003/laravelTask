<?php

namespace App\Repository;

use App\Models\BookDetail;

class BookDetailRepository
{
    public function create($bookDetail)
    {
        return BookDetail::create($bookDetail);
    }

}

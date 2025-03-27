<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BookImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
//    public function startRow(): int
//    {
//        return 2; // Bắt đầu từ dòng thứ 2
//    }
    public function model(array $row)
    {
        return new Book([
            'title' => $row["title"],
            'author' => $row["author"],
            'create_year' => $row["create_year"],
            'amount' => $row["amount"],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bookdetails')->insert([
            // Các phiên bản của sách có book_id = 1
            [
                'book_id' => 1,
                'Day_set' => now()->subDays(10), // Phiên bản cách đây 10 ngày
                'amount_set'=>10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 1,
                'Day_set' => now()->subDays(5), // Phiên bản cách đây 5 ngày
                'amount_set'=>10,

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 1,
                'Day_set' => now(), // Phiên bản mới nhất
                'amount_set'=>10,

                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Các phiên bản của sách có book_id = 2
            [
                'book_id' => 2,
                'Day_set' => now()->subDays(20),
                'amount_set'=>10,

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 2,
                'Day_set' => now()->subDays(15),
                'amount_set'=>10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 2,
                'Day_set' => now()->subDays(2),
                'amount_set'=>10,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Các phiên bản của sách có book_id = 3
            [
                'book_id' => 3,
                'Day_set' => now()->subMonths(2),
                'amount_set'=>10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'book_id' => 3,
                'Day_set' => now()->subMonths(1),
                'amount_set'=>10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

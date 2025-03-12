<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('bookings')->insert([
            [
                'user_id' => 1,
                'total_book' => 2,
                'return_date' => Carbon::now()->addDays(7), // Trả sau 7 ngày
                'status' => 'approved',
                'overdue_status'=>true,
                'created_at' => Carbon::now()->subDays(10), // Đã tạo cách đây 10 ngày
                'updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'user_id' => 2,
                'total_book' => 3,
                'return_date' => Carbon::now()->addDays(5), // Trả sau 5 ngày
                'status' => 'pending',
                'overdue_status'=>true,

                'created_at' => Carbon::now()->subDays(8), // Đã tạo cách đây 8 ngày
                'updated_at' => Carbon::now()->subDays(8),
            ],
            [
                'user_id' => 3,
                'total_book' => 1,
                'return_date' => Carbon::now()->addDays(3), // Trả sau 3 ngày
                'status' => 'returned',
                'overdue_status'=>true,

                'created_at' => Carbon::now()->subDays(6), // Đã tạo cách đây 6 ngày
                'updated_at' => Carbon::now()->subDays(6),
            ],
        ]);
    }
}

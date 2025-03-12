<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BookingTK extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:booking {date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dateInput = $this->argument('date');

        try {
            $date = Carbon::parse($dateInput)->toDateString();
            $this->info($date);
            $results = DB::table('bookings')
                ->whereDate('created_at', $date)
                ->get();

            if ($results->isEmpty()) {
                $this->info("Không có dữ liệu nào vào ngày $date");
            } else {
                $this->info("Dữ liệu vào ngày $date:");
                foreach ($results as $row) {
                    $this->line("ID: {$row->id} - Tổng tiền: {$row->total_book} - Trạng thái: {$row->status}");
                }
                $size=sizeof($results);
                $this->info("Tong so booking: $size");
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
            $this->error('Ngày không hợp lệ! Vui lòng nhập đúng định dạng (YYYY-MM-DD).');
        }
    }
}

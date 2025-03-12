<?php

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule) {
        $schedule->call(function () {
            $bookings = Booking::where('return_date', '<', Carbon::today())->get();
            foreach ($bookings as $booking) {
                $booking->overdue_status=false;
                $booking->save();
            }
        })->everySecond();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

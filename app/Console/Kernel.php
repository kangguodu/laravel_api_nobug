<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Groups::class,
        \App\Console\Commands\Refund_7::class,
        \App\Console\Commands\Refund_24::class,
        \App\Console\Commands\Shipment_7::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('Cancel')->everyMinute();
//        $schedule->command('Refund_7')->everyMinute();
//        $schedule->command('Refund_24')->everyMinute();
//        $schedule->command('Shipment_7')->everyMinute();

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
//        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}



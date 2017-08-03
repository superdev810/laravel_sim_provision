<?php

namespace App\Console;

use App\Console\Commands\CallSoap;
use App\Console\Commands\Inspire;
use App\Console\Commands\ProcessCSV;
use App\Console\Commands\RegisterSimInfo;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Inspire::class,
        ProcessCSV::class,
        CallSoap::class,
        RegisterSimInfo::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('process:csv')->everyMinute();
        $schedule->command('queue:listen')->everyMinute();
    }
}

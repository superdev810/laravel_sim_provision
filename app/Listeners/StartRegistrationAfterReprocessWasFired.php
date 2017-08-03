<?php

namespace App\Listeners;

use App\Events\ReporcessRegistration;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class StartRegistrationAfterReprocessWasFired implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     */
    use InteractsWithQueue;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ReporcessRegistration  $event
     * @return void
     */
    public function handle(ReporcessRegistration $event)
    {
        Log::info("File id recieve:".$event->fileId);
        Artisan::call('sim:register', ['fileId' => $event->fileId]);
    }
}

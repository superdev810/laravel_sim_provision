<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;

class ReporcessRegistration extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     */
    public $fileId;
    
    public function __construct($fileId)
    {
        $this->fileId = $fileId;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}

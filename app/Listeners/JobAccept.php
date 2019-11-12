<?php

namespace App\Listeners;

use App\Events\JobRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobAccept
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  JobRequest  $event
     * @return void
     */
    public function handle(JobRequest $event)
    {
        //
    }
}

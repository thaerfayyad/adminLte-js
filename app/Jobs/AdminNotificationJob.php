<?php

namespace App\Jobs;

use App\Notifications\NewProductNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AdminNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $name ;
    protected $admin ;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $admin)
    {
        //
        $this->name = $name;
        $this->admin = $admin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $this->admin->notify(new NewProductNotification($this->name));

    }
}

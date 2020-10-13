<?php

namespace Jakeydevs\Analytics\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Jakeydevs\Analytics\Models\Pageview;

class ProcessPageview implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The pageview we want to process
     *
     * @param Pageview $pv
     */
    public $pv;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Pageview $pv)
    {
        $this->pv = $pv;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Artisan::call('analytics:parse ' . $this->pv->id);
    }
}

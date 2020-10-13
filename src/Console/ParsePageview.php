<?php

namespace Jakeydevs\Analytics\Console;

use Illuminate\Console\Command;
use Jakeydevs\Analytics\Models\Pageview;

class ParsePageview extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:parse {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will take our data from the recorded pageview and parse extra data from it';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = microtime(true);
        $info = [];

        //-- Get our pageview
        $pv = Pageview::find($this->argument('id', 0));
        if (is_null($pv)) {
            $this->error('[ERROR] Pageview does not exist');
            return 0;
        }
        if ($pv->parsed) {
            $this->error('[ERROR] Pageview already parsed');
            return 0;
        }

        $parse = new \Jakeydevs\Analytics\Actions\Parse;
        $this->info("Pageview " . $pv->id . " - " . $pv->created_at->diffForHumans());

        //-- Useragent
        $ua = $parse->getDeviceInformation($pv->user_agent);
        foreach ($ua as $k => $v) {
            $this->info("   [UA] " . $k . " -> " . $v);
        }
        $info = array_merge($info, $ua);

        //-- Location
        $location = $parse->getLocationFromIP($pv->ip);
        $location = $parse->getLocationFromIP(env('MY_IP'));
        $this->info("   [LOCATION] -> " . $location);
        $info = array_merge($info, [
            'location' => $location,
        ]);

        //-- Time on page
        $time = $parse->getTimeOnPage($pv);
        $this->info("   [TIME] -> " . $time . " Seconds");

        //-- Save
        (new \Jakeydevs\Analytics\Actions\Record)->save(
            $pv,
            $info
        );

        //-- Report
        $took = number_format(microtime(true) - $start, 5);
        $this->info('[DONE] ' . $took . ' s');
        return 0;
    }
}

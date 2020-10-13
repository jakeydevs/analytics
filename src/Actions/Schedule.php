<?php

namespace Jakeydevs\Analytics\Actions;

class Schedule
{

    /**
     * Collate a list of pageviews yet to be parsed
     * and parse them!
     *
     * @return void
     */
    public static function collate()
    {
        $pageviews = Pageview::where('parsed', false)->get();
        foreach ($pageviews as $pv) {
            //-- Process
            \Artisan::call('analytics:parse ' . $pv->id);
        }
    }
}

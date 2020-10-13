<?php

namespace Jakeydevs\Analytics\Actions;

use GeoIp2\Database\Reader;
use Jakeydevs\Analytics\Models\Pageview;
use WhichBrowser\Parser;

class Parse
{

    /**
     * Get data from our useragent
     *
     * @param string $useragent
     * @return array
     */
    public function getDeviceInformation(string $useragent)
    {
        $output = [
            'device' => '',
            'browser' => '',
            'os' => '',
        ];

        $result = new Parser($useragent);
        $output['browser'] = $result->browser->name;
        $output['os'] = $result->os->toString();
        $output['device'] = $result->device->type;

        return $output;
    }

    /**
     * Get our location from an IP Address
     *
     * @param string $ip
     * @return string
     */
    public function getLocationFromIP(string $ip)
    {
        $reader = new Reader(config('analytics.maxmind_db'));

        try {
            $record = $reader->country($ip);
        } catch (\GeoIp2\Exception\AddressNotFoundException $e) {
            return 'NA';
        }

        //-- Return
        return $record->country->isoCode;
    }

    /**
     * From the pageview, check if the user has been on the
     * site before and calculate the time on it
     *
     * @param Pageview $pv
     * @return int
     */
    public function getTimeOnPage(Pageview $pv)
    {
        //-- Our return value!
        $seconds = 0;
        //-- Does the session exists for a previous page view?
        $prev = Pageview::where('session_id', $pv->session_id)
            ->where('id', '<', $pv->id)
            ->orderBy('id', 'desc')
            ->first();

        if ($prev) {
            //-- How long
            $seconds = $pv->created_at->diffInSeconds($prev->created_at);
            //-- Within the bounds?
            if ($seconds <= config('analytics.max_time_spent_on_page', 3600)) {
                //-- SAVE
                $prev->time_spent = $seconds;
                $prev->save();
            }
        }

        //-- Return
        return $seconds;
    }

}

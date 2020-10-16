<?php

namespace Jakeydevs\Analytics\Actions\Stats;

use Jakeydevs\Analytics\Models\Pageview;

class Duration extends Base
{

    /**
     * Get our pageviews for this site
     *
     * @param array $q
     * @return array
     */
    public function get(array $q)
    {
        //-- Calculate query
        $query = $this->getQuery($q);

        //-- Lets grab our pageviews
        $data = Pageview::where('parsed', true)->where('time_spent', '>', 0);
        foreach ($query['period'] as $q) {
            //-- Add this query onto our main data query
            $data->where($q[0], $q[1], $q[2]);
        }
        $period = (int) $data->avg('time_spent');

        $data = Pageview::where('parsed', true)->where('time_spent', '>', 0);
        foreach ($query['compare'] as $q) {
            //-- Add this query onto our main data query
            $data->where($q[0], $q[1], $q[2]);
        }
        $compare = (int) $data->avg('time_spent');

        return [
            'period' => $period,
            'compare' => $compare,
            'change' => $this->getComparison($compare, $period),
        ];
    }
}

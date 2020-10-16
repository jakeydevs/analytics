<?php

namespace Jakeydevs\Analytics\Actions\Stats;

use Jakeydevs\Analytics\Models\Pageview;

class OS extends Base
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
        $data = Pageview::selectRaw('os, count(*) AS count')
            ->distinct('session_id')
            ->where('parsed', true)
            ->groupBy('os')
            ->orderBy('count', 'desc');

        foreach ($query['period'] as $q) {
            //-- Add this query onto our main data query
            $data->where($q[0], $q[1], $q[2]);
        }

        $period = $data->get()->toArray();

        return [
            'period' => $period,
        ];
    }
}

<?php

namespace Jakeydevs\Analytics\Actions\Stats;

use Jakeydevs\Analytics\Models\Pageview;

class Bounce extends Base
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

        //-- Unique views
        $uniques = (new \Jakeydevs\Analytics\Actions\Stats\Unique)->get($q);

        //-- Get sessions
        $pd = PageView::select("*")
            ->fromSub(function ($sub) use ($query) {
                $sub->selectRaw('session_id, COUNT(1) AS count')
                    ->from('pageviews')
                    ->where('parsed', true)
                    ->groupBy('session_id');
                foreach ($query['period'] as $q) {
                    //-- Add this query onto our main data query
                    $sub->where($q[0], $q[1], $q[2]);
                }
            }, 't1')
            ->where('t1.count', 1)
            ->count();

        $cd = PageView::select("*")
            ->fromSub(function ($sub) use ($query) {
                $sub->selectRaw('session_id, COUNT(1) AS count')
                    ->from('pageviews')
                    ->where('parsed', true)
                    ->groupBy('session_id');
                foreach ($query['compare'] as $q) {
                    //-- Add this query onto our main data query
                    $sub->where($q[0], $q[1], $q[2]);
                }
            }, 't1')
            ->where('t1.count', 1)
            ->count();

        //-- Calculate percentage
        $period = 0;
        if (($pd > 0) && $uniques['period'] > 0) {
            $period = ($pd / $uniques['period']) * 100;
        }

        $compare = 0;
        if (($cd > 0) && $uniques['compare'] > 0) {
            $compare = ($cd / $uniques['compare']) * 100;
        }

        return [
            'period' => $period,
            'period_count' => $pd,
            'compare' => $compare,
            'compare_count' => $cd,
            'change' => $this->getComparison($compare, $period),
        ];
    }
}

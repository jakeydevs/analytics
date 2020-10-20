<?php

namespace Jakeydevs\Analytics\Actions;

use Jakeydevs\Analytics\Actions\Period;
use Jakeydevs\Analytics\Models\Pageview;

class Analytics
{

    /**
     * Get pageviews for this date period
     *
     * @param Period $period
     * @return int
     */
    public static function getPageviews(Period $period)
    {
        //-- Create query
        $data = Pageview::where('parsed', true);

        //-- Add our periods
        $data->where('created_at', '>=', $period->startDate)
            ->where('created_at', '<', $period->endDate);

        //-- Count results
        return $data->count();
    }

    /**
     * Get unique sessions for the period
     *
     * @param Period $period
     * @return int
     */
    public static function getUnique(Period $period)
    {
        $sessions = Pageview::where('parsed', true)->distinct('session_id');

        //-- Add our periods
        $sessions->where('created_at', '>=', $period->startDate)
            ->where('created_at', '<', $period->endDate);

        //-- Count results
        return $sessions->count();
    }

    /**
     * Get bounce rate (percentage) for this date period
     *
     * @param Period $period
     * @return float
     */
    public static function getBounceRate(Period $period)
    {
        //-- Get unique data for this period for generating the
        //-- Percentage
        $uniques = \Jakeydevs\Analytics\Actions\Analytics::getUnique($period);

        //-- Query for the bounce rate
        $bounces = PageView::select("*")
            ->fromSub(function ($sub) use ($period) {
                $sub->selectRaw('session_id, COUNT(1) AS count')
                    ->from('pageviews')
                    ->where('parsed', true)
                    ->groupBy('session_id');
                $sub->where('created_at', '>=', $period->startDate)
                    ->where('created_at', '<', $period->endDate);
            }, 't1')
            ->where('t1.count', 1)
            ->count();

        //-- Calc percentage
        $period = 0;
        if (($uniques > 0) && $bounces > 0) {
            $period = ($bounces / $uniques) * 100;
        }

        //-- Return
        return $period;
    }

    /**
     * Get the page duration for this date period
     *
     * @param Period $period
     * @return int seconds
     */
    public static function getDuration(Period $period)
    {
        //-- Generate query
        $data = Pageview::where('parsed', true)->where('time_spent', '>', 0);

        //-- Add our periods
        $data->where('created_at', '>=', $period->startDate)
            ->where('created_at', '<', $period->endDate);

        //-- Return
        return (int) $data->avg('time_spent');
    }

    /**
     * Get the top pages for this date period
     *
     * @param Period $period
     * @return array
     */
    public static function getMostVisitedPages(Period $period)
    {
        //-- Create query
        $data = Pageview::select(\DB::raw('path, count(*) as count'))
            ->where('parsed', true)
            ->distinct('session_id')
            ->groupBy('path')
            ->orderBy('count', 'desc');

        //-- Add our periods
        $data->where('created_at', '>=', $period->startDate)
            ->where('created_at', '<', $period->endDate);

        //-- Array
        $pages = $data->get()->toArray();
        return $pages;
    }

    /**
     * Get the data column aggrgated for the date period
     *
     * @param Period $period
     * @param string $column
     * @return void
     */
    public static function getDataAggregate(Period $period, string $column)
    {
        $data = Pageview::select(\DB::raw($column . ', count(*) as count'))
            ->where('parsed', true)
            ->groupBy($column)
            ->orderBy('count', 'desc');

        //-- Add our periods
        $data->where('created_at', '>=', $period->startDate)
            ->where('created_at', '<', $period->endDate);

        //-- Array
        $pages = $data->get()->toArray();
        return $pages;
    }
}

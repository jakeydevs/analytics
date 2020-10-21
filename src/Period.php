<?php

namespace Jakeydevs\Analytics;

use Carbon\Carbon;

class Period
{

    /** @var Datetime */
    public $startDate;

    /** @var Datetime */
    public $endDate;

    /** @var int */
    public $days;

    public function __construct($startDate, $endDate, $days)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->days = $days;
    }

    /**
     * Create a date period with a difference in days
     *
     * @param int $days
     * @return static
     */
    public static function days(int $days)
    {
        $endDate = Carbon::now();
        $startDate = Carbon::today()->subDays($days)->startofDay();
        return new static($startDate, $endDate, $days);
    }

    /**
     * Create a date period from the user
     *
     * @param Carbon $start
     * @param Carbon $end
     * @return static
     */
    public static function create(Carbon $start, Carbon $end)
    {
        return new static($start, $end, $start->diffInDays($end));
    }

    /**
     * Get a set of dates that relate to the period but can
     * be used as a comparison
     *
     * @param Period $period
     * @param int $days
     * @return static
     */
    public static function compare(Period $period)
    {
        //-- NOTE using clone here, as if we did not, we'd just
        //-- update the period
        $endDate = $period->endDate->clone()->subDays($period->days);
        $startDate = $period->startDate->clone()->subDays($period->days)->startofDay();
        return new static($startDate, $endDate, 0);
    }
}

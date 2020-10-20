<?php

namespace Jakeydevs\Analytics\Actions;

use Carbon\Carbon;

class Period
{

    /** @var Datetime */
    public $startDate;

    /** @var Datetime */
    public $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
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
        return new static($startDate, $endDate);
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
        return new static($start, $end);
    }
}

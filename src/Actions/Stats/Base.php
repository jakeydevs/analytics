<?php

namespace Jakeydevs\Analytics\Actions\Stats;

class Base
{

    /**
     * Process a query from the user into workable
     * clauses
     *
     * @param array $data
     * @return array
     */
    public function getQuery(array $data)
    {
        $output = [
            'period' => [],
            'compare' => [],
        ];

        //-- Generate our starting date which we'll use to create our
        //-- period and comparisons
        $date = \Carbon\Carbon::parse((isset($data['date'])) ? $data['date'] : 'now');

        switch ($data['period']) {
            case "today":
                $sub = 1;
                break;
            case "7days":
                $sub = 7;
                break;
            case "30days":
                $sub = 30;
                break;
            default:
                $sub = (int) str_replace("days", "", $data['period']);
                break;
        }

        //-- Lets build our times
        $output['period'][] = [
            'created_at',
            '>=',
            $date->clone()->setTimeFromTimeString("00:00:00"),
        ];
        $output['period'][] = [
            'created_at',
            '<',
            $date->clone(),
        ];
        $output['compare'][] = [
            'created_at',
            '>=',
            $date->clone()->setTimeFromTimeString("00:00:00")->subDays($sub),
        ];
        $output['compare'][] = [
            'created_at',
            '<=',
            $date->clone()->subDay($sub),
        ];

        //-- Return query
        return $output;
    }

    /**
     * Caculates (in percent) the change between 2 numbers
     *
     * @param int $old
     * @param int $new
     * @return void
     */
    public function getComparison(int $old, int $new)
    {
        if (($old == 0) || ($new == 0)) {return 0;}
        $decreased = $new - $old;
        return ($decreased / $old) * 100;
    }
}

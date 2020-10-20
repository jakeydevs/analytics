<?php

namespace Jakeydevs\Analytics\Traits;

trait Diff
{

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

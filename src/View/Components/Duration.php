<?php

namespace Jakeydevs\Analytics\View\Components;

use Illuminate\View\Component;
use Jakeydevs\Analytics\Period;
use Jakeydevs\Analytics\Traits\Diff;

class Duration extends Component
{
    use Diff;

    //-- Vars
    public $period;
    public $compare;
    public $diff;
    public $diff_date;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Period $p)
    {
        //-- Generate data
        $period = \Jakeydevs\Analytics\Analytics::getDuration($p);
        $compare = \Jakeydevs\Analytics\Analytics::getDuration(Period::compare($p));
        $this->diff = (int) $this->getComparison($compare, $period);

        //-- Convert to a mins:secs
        $this->period = $this->getDateStringFromSeconds($period);
        $this->compare = $this->getDateStringFromSeconds($compare);
        $this->diff_date = $this->getDateStringFromSeconds($this->diff);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('analytics::components.duration');
    }

    /**
     * Convert our date into a better format
     *
     * @param int $seconds
     * @return string
     */
    private function getDateStringFromSeconds($seconds)
    {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        $int = $dtF->diff($dtT);

        if ($int->i > 0) {
            return $int->format('%im %ss');
        } else {
            return $int->format('%ss');
        }
    }
}

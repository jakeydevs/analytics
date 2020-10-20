<?php

namespace Jakeydevs\Analytics\View\Components;

use Illuminate\View\Component;
use Jakeydevs\Analytics\Period;

class Bounce extends Component
{
    //-- Vars
    public $period;
    public $compare;
    public $diff;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Period $p)
    {
        //-- Generate data
        $this->period = \Jakeydevs\Analytics\Analytics::getPageviews($p);
        $this->compare = \Jakeydevs\Analytics\Analytics::getPageviews(Period::compare($p));
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('analytics::components.bounces');
    }
}

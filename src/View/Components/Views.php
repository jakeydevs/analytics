<?php

namespace Jakeydevs\Analytics\View\Components;

use Illuminate\View\Component;
use Jakeydevs\Analytics\Period;
use Jakeydevs\Analytics\Traits\Diff;

class Views extends Component
{
    use Diff;

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
        $this->period = \Jakeydevs\Analytics\Analytics::getUnique($p);
        $this->compare = \Jakeydevs\Analytics\Analytics::getUnique(Period::compare($p));
        $this->diff = $this->getComparison($this->compare, $this->period);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('analytics::components.views');
    }
}

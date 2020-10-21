<?php

namespace Jakeydevs\Analytics\View\Components;

use Illuminate\View\Component;
use Jakeydevs\Analytics\Period;
use Jakeydevs\Analytics\Traits\Diff;

class Uniques extends Component
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
<<<<<<< HEAD
    public function __construct($title = 'Uniques')
    {
        $this->title = $title;

        $data = (new \Jakeydevs\Analytics\Actions\Stats\Unique)->get([
            'period' => 'today',
        ]);
        $this->period = $data['period'];
        $this->compare = $data['compare'];
        $this->diff = $data['change'];
=======
    public function __construct(Period $p)
    {
        //-- Generate data
        $this->period = \Jakeydevs\Analytics\Analytics::getUnique($p);
        $this->compare = \Jakeydevs\Analytics\Analytics::getUnique(Period::compare($p));
        $this->diff = $this->getComparison($this->compare, $this->period);
>>>>>>> 9a4d1f3836733f53f3d3fd75269001c65b7268e3
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('analytics::components.uniques');
    }
}

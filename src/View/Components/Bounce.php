<?php

namespace Jakeydevs\Analytics\View\Components;

use Illuminate\View\Component;

class Bounce extends Component
{
    //-- Vars
    public $title;
    public $period;
    public $compare;
    public $diff;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title = 'Bounce')
    {
        $this->title = $title;

        $data = (new \Jakeydevs\Analytics\Actions\Stats\Bounce)->get([
            'period' => 'today',
        ]);
        $this->period = $data['period'];
        $this->compare = $data['compare'];
        $this->diff = $data['change'];
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

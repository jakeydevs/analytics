<?php

namespace Jakeydevs\Analytics\Actions;

use Jakeydevs\Analytics\Models\Pageview;

class Record
{

    /**
     * Save our data for this pageview
     *
     * @param Pageview $pv
     * @param array $data
     * @return void
     */
    public function save(Pageview $pv, array $data)
    {
        //-- Process cols
        foreach ($data as $key => $value) {
            $pv->$key = $value;
        }
        //-- Delete columns
        $del = config('analytics.delete_senstive', []);
        foreach ($del as $col) {
            $pv->$col = '';
        }

        //-- Save
        $pv->parsed = true;
        $pv->save();
    }
}

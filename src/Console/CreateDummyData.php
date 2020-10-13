<?php

namespace Jakeydevs\Analytics\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Jakeydevs\Analytics\Models\Pageview;

class CreateDummyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytic:data {rows}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create dummy data for testing the analytic package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $start = microtime(true);

        $this->createChunked($this->argument('rows', 100));

        //-- Report
        $took = number_format(microtime(true) - $start, 5);
        $this->info('[DONE] ' . $took . ' s');
        return 0;
    }

    public function createChunked($rows)
    {
        $chunk = 500;
        $chunks = ceil($rows / $chunk);

        //-- Loop through each chunk
        foreach (range(1, $chunks) as $cNum) {

            //-- Empty array to add stuff to
            $insert = [];

            //-- Create specific amount of rows if last chunk
            if ($cNum == $chunks) {
                $chunk = $rows - ($chunk * ($cNum - 1));
            }

            //-- Loop
            foreach (range(0, $chunk) as $n) {
                $p = Pageview::factory()->make();
                $d = $p->toArray();

                //-- Watch out - dates might not insert
                //-- so parse them before adding
                $d['created_at'] = Carbon::parse($d['created_at'])
                    ->format("Y-m-d H:i:s");
                $insert[] = $d;
            }

            //-- Insert our array
            \DB::table('pageviews')->insert($insert);
            $this->info('[CHUNK ' . $cNum . '] Inserted');
        }
    }
}

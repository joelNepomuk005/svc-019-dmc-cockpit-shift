<?php

namespace App\Console\Commands;

use App\Models\CustomerMeasures;
use App\Models\CustomerProject;
use App\Models\Measures;
use App\Models\Product;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SetMeasuresToDone extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SetMeassuresToDone';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $customerMeasures = CustomerMeasures::where('to','<=', Carbon::now())->get();

        foreach ($customerMeasures as $customerMeasure) {

            $customerMeasure->update([
                'state' => 'done',
            ]);
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\CustomerMeasures;
use Carbon\Carbon;
use Illuminate\Console\Command;

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
        $customerMeasures = CustomerMeasures::where('to', '<=', Carbon::now())->get();

        foreach ($customerMeasures as $customerMeasure) {

            $customerMeasure->update([
                'state' => 'done',
            ]);
        }
    }
}

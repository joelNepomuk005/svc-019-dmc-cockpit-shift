<?php

namespace App\Console\Commands;

use App\Models\CustomerProject;
use App\Models\Product;
use Illuminate\Console\Command;

class RefactorProjectCategorieID extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refactorProject:Category';

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
        $projects = CustomerProject::whereBetween('product_categorie', [1, 15])->get();

        foreach ($projects as $project) {
            $product = Product::find($project->product_id[0]);

            $project->update([
                'product_categorie' => $product->category_id,
            ]);
        }
    }
}

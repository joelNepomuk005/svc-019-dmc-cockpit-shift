<?php

namespace Database\Seeders;

use App\Models\ContactType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TestdataContactType extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        ContactType::create([
            'name' => 'E-Mail',
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);

        ContactType::create([
            'name' => 'Telefon',
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);

        ContactType::create([
            'name' => 'Sonstige',
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);

    }
}

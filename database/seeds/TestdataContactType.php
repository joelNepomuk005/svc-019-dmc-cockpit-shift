<?php

namespace Database\Seeders;

use App\Enums\Variables;
use App\Models\ContactType;
use App\Models\Customer;
use App\Models\CustomerBudget;
use App\Models\CustomerContact;
use App\Models\CustomerMeasures;
use App\Models\Measures;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

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
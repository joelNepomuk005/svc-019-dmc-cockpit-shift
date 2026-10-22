<?php

namespace Database\Seeders;

use App\Enums\Variables;
use App\Models\Customer;
use App\Models\CustomerBudget;
use App\Models\CustomerContact;
use App\Models\CustomerMeasures;
use App\Models\Measures;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TestdataCustomersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run(): void
    {
        $this->faker = Faker::create('de_DE');

        $budget_types = ['budget', 'asset'];

        $measure = Measures::create([
            'name' => 'Amazon / Paypal',
            'from' => new Carbon('01.02.2024'),
            'to' => new Carbon('30.04.2024'),
            'customer_ids' => ['2', '1'],
        ]);

        $measure = Measures::create([
            'name' => 'Streaming',
            'from' => new Carbon('01.07.2024'),
            'to' => new Carbon('30.09.2024'),
            'customer_ids' => ['2', '1'],
        ]);

        $measure = Measures::create([
            'name' => 'Top-Merchant',
            'from' => new Carbon('01.11.2024'),
            'to' => new Carbon('31.12.2024'),
            'customer_ids' => ['2', '1'],
        ]);

        foreach (Customer::all() as $customer) {
            $measure_count = Measures::all()->count();

            $customerMeasure = CustomerMeasures::create([
                'customer_id' => $customer->id,
                'measure_id' => rand(1, $measure_count),
                'state' => array_rand(Variables::$measuresStates['states'], 1),
                'from' => Carbon::now()->format('Y-m-d'),
                'to' => Carbon::now()->addMonth(3)->format('Y-m-d'),
                'incentivization' => rand(0, 1),
                'coupon' => rand(0, 1),
                'causer_id' => rand(1, 100),
            ]);

            CustomerBudget::create([
                'customer_id' => $customer->id,
                'amount' => mt_rand(1000 * 10, 500000 * 10) / 10,
                'measure_id' => rand(1, $measure_count),
                'user_id' => 1,
                'budget_type' => $budget_types[array_rand($budget_types, 1)],
            ]);

            CustomerBudget::create([
                'customer_id' => $customer->id,
                'amount' => -mt_rand(1000 * 10, 50000 * 10) / 10,
                'measure_id' => rand(1, $measure_count),
                'user_id' => 1,
                'budget_type' => $budget_types[array_rand($budget_types, 1)],
            ]);

            CustomerContact::create([
                'title' => $this->faker->sentence(2),
                'date' => Carbon::now()->format('Y-m-d'),
                'customer_id' => 1,
                'user_id' => 1,
                'user_id_log' => 1,
            ]);
        }

    }
}

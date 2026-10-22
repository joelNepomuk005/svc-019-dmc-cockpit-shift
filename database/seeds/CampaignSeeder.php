<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CampaignSeeder extends Seeder
{
    public function run()
    {
        DB::table('campaigns')->insert([
            'uuid' => 'a27d2f34-7ba1-41ad-b5c5-ffb48af67ed9',
            'name' => 'Gewinnen 2021 allgemein',
            'images' => null,
            'prefix' => null,
            'start_date' => \Carbon\Carbon::now()->firstOfYear(),
            'end_date' => \Carbon\Carbon::now()->endOfYear(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('campaigns')->insert([
            'uuid' => 'd7b7e7c0-94a9-42ff-8288-997af664967a',
            'name' => 'Gewinnen 2021 Siegen',
            'images' => null,
            'prefix' => null,
            'start_date' => \Carbon\Carbon::now()->firstOfYear(),
            'end_date' => \Carbon\Carbon::now()->endOfYear(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('campaigns')->insert([
            'uuid' => '3a2c622f-6715-4741-9dba-b5a1bbde868c',
            'name' => 'Gewinnen 2022',
            'images' => null,
            'prefix' => null,
            'start_date' => \Carbon\Carbon::now()->firstOfYear(),
            'end_date' => \Carbon\Carbon::now()->endOfYear(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\ContactType;
use App\Models\JobTitle;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);

        if (env('APP_ENV') === 'local' || env('APP_ENV') === 'development') {
            $this->call(InstituteSeeder::class);
            $this->call(TestdataCustomersTableSeeder::class);
            $this->call(UserCategoriesSeeder::class);
            $this->call(JobtitlesSeeder::class);
            $this->call(TestdataContactType::class);
            $this->call(CampaignSeeder::class);
        }
    }
}

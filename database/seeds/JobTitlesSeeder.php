<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JobtitlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('job_titles')->insert([
            0 => [
                'id' => 1,
                'name' => 'IT',
                'deleted_at' => null,
                'created_at' => '2019-05-01 00:00:00',
                'updated_at' => '2019-05-01 00:00:00',
            ],
            1 => [
                'id' => 2,
                'name' => 'Vertrieb 1',
                'deleted_at' => 'NULL',
                'created_at' => '2019-05-01 00:00:00',
                'updated_at' => '2019-05-01 00:00:00',
            ],
            2 => [
                'id' => 3,
                'name' => 'Vertrieb 2',
                'deleted_at' => null,
                'created_at' => '2019-05-01 00:00:00',
                'updated_at' => '2019-05-01 00:00:00',
            ],
            3 => [
                'id' => 4,
                'name' => 'Key Account Manager DSV',
                'deleted_at' => null,
                'created_at' => '2019-05-01 00:00:00',
                'updated_at' => '2019-05-01 00:00:00',
            ],
        ]);
    }
}

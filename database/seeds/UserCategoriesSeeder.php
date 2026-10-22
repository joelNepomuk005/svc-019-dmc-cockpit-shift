<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('user_categories')->insert([
            0 => [
                'id' => 1,
                'name' => 'Vertrieb Mehrwerte & Beratung',
                'deleted_at' => null,
                'created_at' => '2019-05-01 00:00:00',
                'updated_at' => '2019-05-01 00:00:00',
            ],
            1 => [
                'id' => 2,
                'name' => 'Marktfolgedienste Mehrwerte',
                'deleted_at' => null,
                'created_at' => '2019-05-01 00:00:00',
                'updated_at' => '2019-05-01 00:00:00',
            ],
            2 => [
                'id' => 3,
                'name' => 'Vertrieb Medialer Kundenservice',
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

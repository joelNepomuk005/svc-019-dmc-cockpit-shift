<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('user_categories')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Vertrieb Mehrwerte & Beratung',
                    'deleted_at' => NULL,
                    'created_at' => '2019-05-01 00:00:00',
                    'updated_at' => '2019-05-01 00:00:00',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Marktfolgedienste Mehrwerte',
                    'deleted_at' => NULL,
                    'created_at' => '2019-05-01 00:00:00',
                    'updated_at' => '2019-05-01 00:00:00',
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Vertrieb Medialer Kundenservice',
                    'deleted_at' => NULL,
                    'created_at' => '2019-05-01 00:00:00',
                    'updated_at' => '2019-05-01 00:00:00',
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Key Account Manager DSV',
                    'deleted_at' => NULL,
                    'created_at' => '2019-05-01 00:00:00',
                    'updated_at' => '2019-05-01 00:00:00',
                ),
        ));
    }
}

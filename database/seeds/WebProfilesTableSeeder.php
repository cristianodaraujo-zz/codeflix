<?php

use Illuminate\Database\Seeder;

class WebProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\WebProfile::class, 5)->create();
    }
}
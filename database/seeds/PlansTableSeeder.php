<?php

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $webProfiles = app(\App\Repositories\WebProfileRepository::class)->all();

        factory(\App\Models\Plan::class)
            ->states(\App\Models\Plan::DURATION_YEARLY)
            ->create(['web_profile_id' => $webProfiles->random()->id]);
        factory(\App\Models\Plan::class)
            ->states(\App\Models\Plan::DURATION_MONTHLY)
            ->create(['web_profile_id' => $webProfiles->random()->id]);
    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \File::deleteDirectory(config('filesystems.disks.video.root'), true);

        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(PlaylistsTableSeeder::class);
        $this->call(VideosTableSeeder::class);
        $this->call(WebProfilesTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(SubscriptionsTableSeeder::class);
    }
}

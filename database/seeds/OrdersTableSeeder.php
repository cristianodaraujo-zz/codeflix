<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all();

        factory(\App\Models\Order::class, 5)->make()->each(function ($order) use ($users) {
           $order->user_id = $users->random()->id;
           $order->save();
        });
    }
}

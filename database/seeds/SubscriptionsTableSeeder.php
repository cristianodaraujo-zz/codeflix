<?php

use Illuminate\Database\Seeder;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = \App\Models\Plan::all();
        $orders = \App\Models\Order::all();

        $repository = app(\App\Repositories\SubscriptionRepository::class);

        foreach (range(1, 10) as $_) {
            $repository->create([
                'plan_id' => $plans->random()->id,
                'order_id' => $orders->random()->id
            ]);
        }
    }
}

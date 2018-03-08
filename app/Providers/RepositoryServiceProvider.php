<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\CategoryRepositoryEloquent;
use App\Repositories\OrderRepository;
use App\Repositories\OrderRepositoryEloquent;
use App\Repositories\PlanRepository;
use App\Repositories\PlanRepositoryEloquent;
use App\Repositories\PlaylistRepository;
use App\Repositories\PlaylistRepositoryEloquent;
use App\Repositories\SubscriptionRepository;
use App\Repositories\SubscriptionRepositoryEloquent;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryEloquent;
use App\Repositories\VideoRepository;
use App\Repositories\VideoRepositoryEloquent;
use App\Repositories\WebProfileRepository;
use App\Repositories\WebProfileRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(CategoryRepository::class, CategoryRepositoryEloquent::class);
        $this->app->bind(PlaylistRepository::class, PlaylistRepositoryEloquent::class);
        $this->app->bind(VideoRepository::class, VideoRepositoryEloquent::class);
        $this->app->bind(WebProfileRepository::class, WebProfileRepositoryEloquent::class);
        $this->app->bind(PlanRepository::class, PlanRepositoryEloquent::class);
        $this->app->bind(OrderRepository::class, OrderRepositoryEloquent::class);
        $this->app->bind(SubscriptionRepository::class, SubscriptionRepositoryEloquent::class);
        //:end-bindings:
    }
}

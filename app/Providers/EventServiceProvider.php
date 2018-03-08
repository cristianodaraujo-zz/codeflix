<?php

namespace App\Providers;

use App\Listeners\AddTokenToHeaderListener;
use App\Listeners\CreateOrderListener;
use App\Listeners\CreateSubscriptionListener;
use App\Listeners\CreateWebProfileListener;
use App\Listeners\UpdateWebProfileListener;
use App\Listeners\DeleteWebProfileListener;
use Dingo\Api\Event\ResponseWasMorphed;
use App\Events\PayPalPaymentApproved;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Prettus\Repository\Events\RepositoryEntityCreated;
use Prettus\Repository\Events\RepositoryEntityDeleted;
use Prettus\Repository\Events\RepositoryEntityUpdated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ResponseWasMorphed::class => [
            AddTokenToHeaderListener::class,
        ],
        PayPalPaymentApproved::class => [
            CreateOrderListener::class
        ],
        RepositoryEntityCreated::class => [
            CreateSubscriptionListener::class,
            CreateWebProfileListener::class,
        ],
        RepositoryEntityUpdated::class => [
            UpdateWebProfileListener::class
        ],
        RepositoryEntityDeleted::class => [
            DeleteWebProfileListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

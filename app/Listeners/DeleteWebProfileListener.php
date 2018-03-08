<?php

namespace App\Listeners;

use App\Models\WebProfile;
use App\PayPal\WebProfileClient;
use Prettus\Repository\Events\RepositoryEntityDeleted;

class DeleteWebProfileListener
{
    /**
     * @var WebProfileClient
     */
    private $webProfileClient;

    /**
     * Create the event listener.
     *
     * @param WebProfileClient $webProfileClient
     */
    public function __construct(WebProfileClient $webProfileClient)
    {
        $this->webProfileClient = $webProfileClient;
    }

    /**
     * Handle the event.
     *
     * @param  RepositoryEntityDeleted  $event
     * @return void
     */
    public function handle(RepositoryEntityDeleted $event)
    {
        $model = $event->getModel();

        if (! ($model instanceof WebProfile)) {
            return;
        }

        $this->webProfileClient->delete($model->code);
    }
}

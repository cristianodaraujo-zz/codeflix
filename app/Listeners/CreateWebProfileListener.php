<?php

namespace App\Listeners;

use App\Models\WebProfile;
use App\PayPal\WebProfileClient;
use App\Repositories\WebProfileRepository;
use Prettus\Repository\Events\RepositoryEntityCreated;

class CreateWebProfileListener
{
    /**
     * @var WebProfileClient
     */
    private $webProfileClient;

    /**
     * @var WebProfileRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @param WebProfileClient $webProfileClient
     * @param WebProfileRepository $repository
     */
    public function __construct(WebProfileClient $webProfileClient, WebProfileRepository $repository)
    {
        $this->webProfileClient = $webProfileClient;
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  RepositoryEntityCreated  $event
     * @return void
     */
    public function handle(RepositoryEntityCreated $event)
    {
        $model = $event->getModel();

        if (! ($model instanceof WebProfile)) {
            return;
        }

        $webProfile = $this->webProfileClient->create($model);

        \Config::set('web_profile_created', true);

        $this->repository->update([
            'code' => $webProfile->getId()
        ], $model->id);
    }
}

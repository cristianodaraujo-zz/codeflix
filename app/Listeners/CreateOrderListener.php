<?php

namespace App\Listeners;

use App\Events\PayPalPaymentApproved;
use App\Repositories\OrderRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateOrderListener
{
    /**
     * @var OrderRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @param OrderRepository $repository
     */
    public function __construct(OrderRepository $repository)
    {
        //
        $this->repository = $repository;
    }

    /**
     * Handle the event.
     *
     * @param  PayPalPaymentApproved  $event
     * @return void
     */
    public function handle(PayPalPaymentApproved $event)
    {
        $order = $this->repository->create([
            'user_id' => \Auth::guard('api')->user()->id,
            'value' => $event->getPlan()->value,
            'code' => $event->getPayment()->getId(),
        ]);

        $event->setOrder($order);
    }
}

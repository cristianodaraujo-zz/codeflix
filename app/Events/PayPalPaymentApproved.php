<?php

namespace App\Events;


use App\Models\Plan;
use PayPal\Api\Payment;

class PayPalPaymentApproved
{
    /**
     * @var Plan
     */
    private $plan;

    /**
     * @var $order
     */
    private $order;

    /**
     * @var Payment
     */
    private $payment;


    /**
     * Create a new event instance.
     *
     * @param Plan $plan
     * @param Payment $payment
     */
    public function __construct(Plan $plan, Payment $payment)
    {
        $this->plan = $plan;
        $this->payment = $payment;
    }

    /**
     * @return Plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }

}

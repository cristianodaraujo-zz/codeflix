<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Plan;
use App\PayPal\PaymentClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    /**
     * @var PaymentClient
     */
    private $paymentClient;

    /**
     * PaymentClient constructor.
     * @param PaymentClient $paymentClient
     */
    public function __construct(PaymentClient $paymentClient)
    {
        $this->paymentClient = $paymentClient;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderRequest $request
     * @param Plan $plan
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request, Plan $plan)
    {
        $payment = $this->paymentClient->does(
            $plan, $request->get('payment_id'), $request->get('payer_id')
        );

        return $payment;

    }

    public function apply(Plan $plan)
    {
        $payment = $this->paymentClient->make($plan);

        return [
            'payment_id' => $payment->getId(),
            'approval_url' => $payment->getApprovalLink(),
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}

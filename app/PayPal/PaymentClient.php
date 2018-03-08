<?php

namespace App\PayPal;

use App\Events\PayPalPaymentApproved;
use App\Models\Plan;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payee;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

class PaymentClient
{
    /**
     * @var ApiContext
     */
    private $apiContext;

    /**
     * PaymentClient constructor.
     * @param ApiContext $apiContext
     */
    public function __construct(ApiContext $apiContext)
    {
        $this->apiContext = $apiContext;
    }

    public function get($paymentId)
    {
        return Payment::get($paymentId, $this->apiContext);
    }

    public function does(Plan $plan, $paymentId, $payerId)
    {
        $details = new Details();
        $details
            ->setShipping(0)
            ->setTax(0)
            ->setSubtotal($plan->value);

        $amount = new Amount();
        $amount
            ->setCurrency('BRL')
            ->setTotal($plan->value)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $execution = new PaymentExecution();
        $execution
            ->setPayerId($payerId)
            ->addTransaction($transaction);

        $payment = Payment::get($paymentId, $this->apiContext);
        $payment->execute($execution, $this->apiContext);

        $event = new PayPalPaymentApproved($plan, $payment);
        event($event);
        return $event->getOrder();
    }

    /**
     * @param Plan $plan
     * @return Payment
     * @throws \Exception
     */
    public function make(Plan $plan)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item = new Item();
        $item
            ->setName("Plano ". Plan::duration($plan->duration))
            ->setSku($plan->sku)
            ->setCurrency('BRL')
            ->setQuantity(1)
            ->setPrice($plan->value);

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $details = new Details();
        $details
            ->setShipping(0)
            ->setTax(0)
            ->setSubtotal($plan->value);

        $amount = new Amount();
        $amount
            ->setCurrency('BRL')
            ->setTotal($plan->value)
            ->setDetails($details);

        $payee = new Payee();
        $payee->setEmail(env('PAYPAL_PAYEE_EMAIL'));

        $transaction = new Transaction();
        $transaction
            ->setItemList($itemList)
            ->setAmount($amount)
            ->setDescription("Pagamento do plano de assinatura")
            ->setPayee($payee)
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls
            ->setReturnUrl(url('/') ."/payment/success")
            ->setCancelUrl(url('/') ."/payment/cancel");

        $payment = new Payment();
        $payment
            ->setExperienceProfileId($plan->webProfile->code)
            ->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->apiContext);
        } catch (PayPalConnectionException $exception) {
            \Log::error($exception->getMessage(), ['data' => $exception->getData()]);
            throw $exception;
        }

        return $payment;
    }
}
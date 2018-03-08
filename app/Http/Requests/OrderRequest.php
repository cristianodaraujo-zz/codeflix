<?php

namespace App\Http\Requests;

use App\Models\Plan;
use App\PayPal\PaymentClient;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * @var PaymentClient
     */
    private $paymentClient;

    /**
     * OrderRequest constructor.
     * @param PaymentClient $paymentClient
     */
    public function __construct(PaymentClient $paymentClient)
    {
        $this->paymentClient = $paymentClient;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $paymentId = $this->get('payment_id');

        if (! $paymentId) {
            return false;
        }
        $payment = $this->paymentClient->get($paymentId);
        $planSku = $payment->getTransactions()[0]->getItemList()->getItems()[0]->getSku();

        return Plan::getIdFromSku($planSku) == $this->route('plan')->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payer_id' => 'required'
        ];
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\SubscriptionRepository;

class SubscriptionsController extends Controller
{
    /**
     * @var SubscriptionRepository
     */
    private $repository;

    /**
     * SubscriptionsController constructor.
     * @param SubscriptionRepository $repository
     */
    public function __construct(SubscriptionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->repository->with('plan')->whereHas('order', function ($query) {
            $query->where('user_id', \Auth::guard('api')->user()->id);
        })->all();
    }
}
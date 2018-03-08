<?php

namespace App\Http\Controllers\Admin;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $subscriptions = $this->repository->paginate(10);

        return view('admin.subscriptions.index', compact('subscriptions'));
    }
}
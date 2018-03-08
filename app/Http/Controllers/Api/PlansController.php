<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PlanRepository;

class PlansController extends Controller
{
    /**
     * @var PlanRepository
     */
    private $repository;

    /**
     * PlansController constructor.
     * @param PlanRepository $repository
     */
    public function __construct(PlanRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->all();
    }
}
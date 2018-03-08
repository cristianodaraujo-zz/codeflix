<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AddCpfRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * RegisterController constructor.
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function changePassword(PasswordUpdateRequest $request)
    {
        $this->repository->update(
            $request->only('password'),
            $request->user('api')->id
        );

        return $request->user('api');
    }

    public function addCpf(AddCpfRequest $request)
    {
        $user = $this->repository->update([
            'cpf' => $request->input('cpf')
        ], $request->user('api')->id);

        return $user;
    }

}

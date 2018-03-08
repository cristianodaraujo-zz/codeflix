<?php

namespace App\Http\Controllers\Api;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Two\User;

class RegisterUsersController extends Controller
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

    public function store(Request $request)
    {
        $accessToken = str_replace('bearer ', '', $request->header('Authorization'));
        $facebook = \Socialite::driver('facebook');
        /** @var User $userSocial */
        $userSocial = $facebook->userFromToken($accessToken);
        $user = $this->repository->findByField('email', $userSocial->email)->first();

        if (! $user) {
            \App\Models\User::unguard();

            $user = $this->repository->create([
                'name' => $userSocial->name,
                'email' => $userSocial->email,
                'role' => \App\Models\User::ROLE_CLIENT,
                'verified' => true
            ]);

            \App\Models\User::reguard();
        }

        return [
            'token' => \Auth::guard('api')->tokenById($user->id)
        ];
    }
}

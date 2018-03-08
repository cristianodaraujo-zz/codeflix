<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Jrean\UserVerification\Traits\VerifiesUsers;

class EmailVerificationController extends Controller
{
    use VerifiesUsers;
    /**
     * @var UserRepository
     */
    private $repository;


    /**
     * EmailVerificationController constructor.
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function redirectAfterVerification()
    {
        $this->forcedLogin();

        return url('password/change');
    }

    protected function forcedLogin()
    {
        $email = \Request::get('email');
        \Auth::login($this->repository->findByField('email', $email)->first());
    }
}

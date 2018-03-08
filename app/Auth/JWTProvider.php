<?php

namespace App\Auth;

use Dingo\Api\Auth\Provider\Authorization;
use Dingo\Api\Routing\Route;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWT;

class JWTProvider extends Authorization
{
    /**
     * @var JWT
     */
    private $jwt;

    /**
     * JWTProvider constructor.
     * @param JWT $jwt
     */
    public function __construct(JWT $jwt)
    {

        $this->jwt = $jwt;
    }

    /**
     * Get the providers authorization method.
     *
     * @return string
     */
    public function getAuthorizationMethod()
    {
        return 'bearer';
    }

    /**
     * Authenticate the request and return the authenticated user instance.
     *
     * @param Request $request
     * @param Route $route
     *
     * @return mixed
     */
    public function authenticate(Request $request, Route $route)
    {
        try {
            return \Auth::guard('api')->authenticate();
        } catch (AuthenticationException $exception) {
            $this->refreshToken();

            return \Auth::guard('api')->user();
        }
    }

    protected function refreshToken()
    {
        $this->jwt->setToken($this->jwt->parseToken()->refresh());
    }
}
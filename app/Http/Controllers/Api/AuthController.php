<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    public function accessToken(Request $request)
    {
        $this->validateLogin($request);

        if ($token = \Auth::guard('api')->attempt($this->credentials($request))) {
            return $this->sendLoginResponse($token);
        }

        return $this->sendFailedLoginResponse();
    }

    protected function sendLoginResponse($token)
    {
        return response()->json(compact('token'));
    }

    protected function sendFailedLoginResponse()
    {
        return response()->json([
            'error' => \Lang::get('auth.failed')
        ], 400);
    }

    public function logout()
    {
        \Auth::guard('api')->logout();

        return response()->json([], 204);
    }

    public function refreshToken()
    {
        return $this->sendLoginResponse(\Auth::guard('api')->refresh());
    }
}

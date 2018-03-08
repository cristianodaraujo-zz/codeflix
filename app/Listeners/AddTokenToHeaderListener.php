<?php

namespace App\Listeners;

use Dingo\Api\Event\ResponseWasMorphed;
use Tymon\JWTAuth\JWT;

class AddTokenToHeaderListener
{
    /**
     * @var JWT
     */
    private $jwt;

    /**
     * Create the event listener.
     *
     * @param JWT $jwt
     */
    public function __construct(JWT $jwt)
    {
        $this->jwt = $jwt;
    }

    /**
     * Handle the event.
     *
     * @param  ResponseWasMorphed  $event
     * @return void
     */
    public function handle(ResponseWasMorphed $event)
    {
        if ($token = $this->jwt->getToken()) {
            $event->response->headers->set('Authorization', "bearer {$token->get()}");
        }
    }
}

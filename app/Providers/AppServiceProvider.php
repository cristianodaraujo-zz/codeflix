<?php

namespace App\Providers;

use App\Exceptions\SubscriptionInvalidException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\ValidationException;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Tymon\JWTAuth\Exceptions\JWTException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\Video::updated(function ($video) {
            if (! $video->completed && $video->archive != null && $video->thumbnail != null) {
                $video->completed = true;
                $video->save();
            }
        });

        \Validator::extend('cpf', function($attribute, $value, $parameters, $validator) {
            return (new \Code\Validator\Cpf())->isValid($value);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $this->app->register(\Laravel\Dusk\DuskServiceProvider::class);
        }
        // ...

        // Overwriting registerFormBuilder
        $this->app->bind(
            'bootstrapper::form',
            function ($app) {
                $form = new Form(
                    $app->make('collective::html'),
                    $app->make('url'),
                    $app->make('view'),
                    $app['session.store']->token()
                );

                return $form->setSessionStore($app['session.store']);
            },
            true
        );

        // API PayPal
        $this->app->bind(ApiContext::class, function() {
            $apiContext = new ApiContext(new OAuthTokenCredential(
                env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET')
            ));

            $apiContext->setConfig([
                'http.CURLOPT_CONNECTIONTIMEOUT' => 45
            ]);

            return $apiContext;
        });

        // Exceptions
        $handler = app(\Dingo\Api\Exception\Handler::class);

        $handler->register(function (AuthenticationException $exception) {
            return response()->json([
                'error' => 'unauthenticated',
                'message' => $exception->getMessage()
            ], 401);
        });

        $handler->register(function (JWTException $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 401);
        });

        $handler->register(function (ValidationException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'validation_errors' => $exception->validator->getMessageBag()->toArray()
            ], 422);
        });

        $handler->register(function (SubscriptionInvalidException $exception) {
            return response()->json([
                'error' => 'subscription_valid_not_found',
                'message' => $exception->getMessage()
            ], 403);
        });
    }
}

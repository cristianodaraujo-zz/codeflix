<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Dingo\Api\Auth\Auth;
use Dingo\Api\Routing\UrlGenerator;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tymon\JWTAuth\JWT;
use Tymon\JWTAuth\JWTGuard;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    public function testAccessToken()
    {
        $this->makeToken()->assertStatus(200)->assertJsonStructure(['token']);
    }

    public function testLogout()
    {
        $token = $this->makeToken()->json()['token'];

        $this->get('api/user', [
            'Authorization' => "bearer $token"
        ]);

        $this->post('api/logout')->assertStatus(204);

        $this->clearAuth();

        $this->post('api/logout')->assertStatus(500);
    }

    public function testNotAuthorizedAccessApi()
    {
        $this->get('api/user')->assertStatus(500);
    }

    public function testAccessCategories()
    {
        $token = $this->makeToken()->json()['token'];

        $this->get('api/user', [
            'Authorization' => "bearer $token"
        ]);

        factory(Category::class)->create([
            'name' => 'test'
        ]);

        $this->get('api/categories')->assertJsonStructure([
            'categories' => [['name']]
        ])->assertStatus(200);
    }

    public function testRefreshToken()
    {
        $token = $this->makeToken()->json()['token'];

        sleep(61);

        $this->clearAuth();

        $response = $this->get('api/user', [
            'Authorization' => "bearer $token"
        ])->assertJsonStructure(['user' => ['name']]);

        $bearer = $response->baseResponse->headers->get('Authorization');

        $this->assertNotEquals("bearer $token", $bearer);

        sleep(31);

        $this->clearAuth();

        $this->get('api/user', [
            'Authorization' => "bearer $token"
        ])->assertStatus(500);
    }

    protected function clearAuth()
    {
        $reflectionClass = new \ReflectionClass(JWTGuard::class);

        $reflectionProperty = $reflectionClass->getProperty('user');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue(\Auth::guard('api'), null);

        app(JWT::class)->unsetToken();
        app(Auth::class)->setUser(null);
    }

    protected function makeToken()
    {
        $urlGenerator = app(UrlGenerator::class)->version('v1');

        return $this->post($urlGenerator->route('api.access-token'), [
            'email' => 'admin@user.com',
            'password' => 'secret'
        ]);
    }
}

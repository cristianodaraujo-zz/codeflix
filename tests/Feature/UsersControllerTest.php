<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserNotLoggedIn()
    {
        $this->get(route('admin.users.index'))
            ->assertRedirect(route('admin.login'))
            ->assertStatus(302);
    }

    public function testUserLoggedIn()
    {
        $this->actingAs(
            User::whereEmail('admin@user.com')->first()
        )->get(route('admin.users.index'))
            ->assertSee('Listagem de usuários');
    }
}

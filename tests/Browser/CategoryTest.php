<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCRUD()
    {
        $this->browse(function (Browser $browser) {
            // login
            $browser->visit('/admin/login')
                ->type('email', 'admin@user.com')
                ->type('password', 'secret')
                ->press('Login')
                ->assertSee('CodeFlix')
                // list
                ->visit('/admin/categories')
                ->assertSee('Listagem de categorias')
                ->clickLink('Nova categoria')
                // create
                ->assertSee('Nova categoria')
                ->type('name', 'Test')
                ->click('button[type="submit"]')
                ->assertSee('Categoria cadastrada com sucesso!')
                // update
                ->assertSee('Test')
                ->click('.glyphicon-pencil')
                ->assertSee('Editar categoria')
                ->type('name', 'Test edited')
                ->click('button[type="submit"]')
                ->assertSee('Categoria alterada com sucesso!')
                // show
                ->assertSee('Test edited')
                ->click('.glyphicon-remove')
                ->assertSee('Ver categoria')
                // delete
                ->assertSee('Test edited')
                ->click('.glyphicon-remove')
                ->assertSee('Categoria excluída com sucesso!');
        });
    }
}

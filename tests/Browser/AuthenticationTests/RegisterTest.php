<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test that we can auth by created user.
     *
     * @return void
     */
    public function testCanRegister()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('name', 'noldor')
                ->type('email', 'romanov@noldor.pro')
                ->type('password', 'secret')
                ->type('password_confirmation', 'secret')
                ->press('Зарегистрироваться')
                ->assertPathIs('/');
        });

        $this->assertDatabaseHas('users',
            [
                'name'  => 'noldor',
                'email' => 'romanov@noldor.pro'
            ]
        );
    }
}

<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test that we can auth by created user.
     *
     * @return void
     */
    public function testCanLogin()
    {
        $user = factory(User::class)->create([
            'email'    => 'romanov@noldor.pro',
            'password' => bcrypt('secret')
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->press('Войти')
                ->assertPathIs('/');
        });
    }
}

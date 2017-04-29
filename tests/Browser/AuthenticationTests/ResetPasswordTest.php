<?php

namespace Tests\Browser\AuthenticationTests;

use App\User;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ResetPasswordTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * @var User
     */
    private $user;

    /**
     * Test reset password and authentication with new credentials.
     *
     * @return void
     */
    public function testResetPassword()
    {
        $user = $this->user = factory(User::class)->create([
            'email'    => 'romanov@noldor.pro',
            'password' => bcrypt('secret')
        ]);
        $token = $this->app->make(PasswordBroker::class)->createToken($user);

        $targetUrl = '/password/reset/' . $token;

        $this->browse(function (Browser $browser) use ($targetUrl, $user) {
            $browser->visit($targetUrl)
                ->type('email', $user->email)
                ->type('password', 'newsecret')
                ->type('password_confirmation', 'newsecret')
                ->press('Обновить пароль');
        });

        $this->browse(function (Browser $browser) {
            $browser->logout()
                ->visit('/login')
                ->assertPathIs('/login')
                ->type('email', 'romanov@noldor.pro')
                ->type('password', 'newsecret')
                ->press('Войти')
                ->assertPathIs('/');
        });
    }
}

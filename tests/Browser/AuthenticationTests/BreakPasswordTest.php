<?php

namespace Tests\Browser\AuthenticationTests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RememberPasswordTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Test that we can send mail for resetting password.
     *
     * @return void
     */
    public function testBreakPassword()
    {
        /** @var User $user */
        $user = factory(\App\Models\User::class)->create([
            'email'    => 'romanov@noldor.pro',
            'password' => bcrypt('secret')
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/password/reset')
                ->type('email', $user->email)
                ->press('Отправить ссылку на смену пароля')
                ->assertPathIs('/password/reset')
                ->assertSee('На ваш email отправлена ссылка для сброса пароля!');
        });
    }
}

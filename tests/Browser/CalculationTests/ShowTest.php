<?php

namespace Tests\Browser\CalculationTests;

use App\Models\Calculation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ShowTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @var \App\Models\Calculation
     */
    protected $user;

    /**
     * @var \App\Models\Calculation
     */
    protected $calculation;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create([
            'password' => bcrypt('secret'),
            'role'     => 'Admin'
        ]);

        factory(Calculation::class)->times(100)->create(['user_id' => $this->user->id]);
    }

    /**
     * A Dusk test example.
     *
     * @group Calculations
     * @return void
     */
    public function testCanShowEntity()
    {
        $user = $this->user;
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);
            $browser->visitRoute('calculations.index')
                ->assertSee('Название');

            $name = $browser->text('#calculation-1 td:first-child');

            $browser->click('.btn-group a:first-child')
                ->assertInputValue('#name', $name)
                ->click('.panel-footer .btn-default')
                ->assertRouteIs('calculations.index');
        });
    }
}

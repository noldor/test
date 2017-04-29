<?php

namespace Tests\Browser\CalculationTests;

use App\Models\Calculation;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DestroyTest extends DuskTestCase
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
    public function testDeleteEntity()
    {
        $user = $this->user;
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);
            $browser->visitRoute('calculations.index')
                ->assertSee('Название');

            $name = $browser->text('#calculation-1 td:first-child');

            $browser->click('.calculation-delete')
                ->waitFor('.swal2-confirm')
                ->click('.swal2-confirm')
                ->waitUntilMissing('.swal2-container')
                ->assertDontSee($name)
                ->visitRoute('calculations.index')
                ->pause(500)
                ->assertDontSee($name);
        });
    }
}

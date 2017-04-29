<?php

namespace Tests\Browser\CalculationTests;

use App\Models\Calculation;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditTest extends DuskTestCase
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

        factory(Calculation::class)->times(1)->create(['user_id' => $this->user->id]);
    }

    /**
     * A Dusk test example.
     *
     * @group Calculations
     * @return void
     */
    public function testCanEditEntity()
    {
        $user = $this->user;
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);
            $browser->visitRoute('calculations.index');

            $name = $browser->text('#calculation-1 td:first-child');
            $newName = 'New name';

            $link = $browser->attribute('#calculation-1 td:first-child', 'href');

            $browser->click('.btn-group a:nth-child(2)')
                ->waitForLink($link)
                ->clear('name')
                ->type('name', $newName)
                ->press('Сохранить')
                ->waitFor('.swal2-confirm')
                ->click('.swal2-confirm')
                ->pause(1000)
                ->assertDontSee($name)
                ->assertSee($newName);
        });
    }
}

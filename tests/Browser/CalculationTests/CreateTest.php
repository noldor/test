<?php

namespace Tests\Browser\CalculationTests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @var User
     */
    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create([
            'email'    => 'romanov@noldor.pro',
            'password' => bcrypt('secret')
        ]);
    }

    /**
     * Test add new entity to database.
     *
     * @group Calculations
     * @return void
     */
    public function testCanCreateNewEntity()
    {
        $user = $this->user;
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);
            $browser->visitRoute('calculations.index')
                ->visitRoute('calculations.create')
                ->assertSee('Результаты расчета')
                ->type('name', 'название расчета')
                ->type('source', 'исходные данные')
                ->press('Сохранить')
                ->waitFor('.swal2-confirm')
                ->click('.swal2-confirm')
                ->waitForLocation('/calculations')
                ->assertRouteIs('calculations.index');
        });

        $this->assertDatabaseHas('calculations', [
            'id'      => 1,
            'name'    => 'название расчета',
            'source'  => 'исходные данные',
            'user_id' => $user->id
        ]);
    }

    /**
     * Test add new entity with not valid data.@expectedException
     *
     * @group Calculations
     * @return void
     */
    public function testCanNotValidateNewEntityThanCorrectErrorsAndSaveEntity()
    {
        $user = $this->user;
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);
            $browser->visitRoute('calculations.index')
                ->visitRoute('calculations.create')
                ->assertSee('Результаты расчета')
                ->type('name',
                    'название расчета название расчета название расчета название расчета название расчета название расчета название расчета название расчета название расчета название расчета название расчета название расчета название расчета название расчета название расчета название расчета название расчета')
                ->type('source', '')
                ->press('Сохранить')
                ->waitFor('#errors-list')
                ->pause(1000)
                ->assertSee('Количество символов в поле name не может превышать 255.')
                ->assertSee('Поле source обязательно для заполнения.')
                ->assertRouteIs('calculations.create');

            $browser->type('name', 'Some name')
                ->type('source', 'some source')
                ->press('Сохранить')
                ->waitUntilMissing('#errors-list')
                ->waitFor('.swal2-confirm')
                ->click('.swal2-confirm')
                ->waitForLocation('/calculations')
                ->assertRouteIs('calculations.index')
                ->assertSee('Some name');
        });
    }
}

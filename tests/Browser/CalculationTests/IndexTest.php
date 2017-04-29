<?php

namespace Tests\Browser\CalculationTests;

use App\Models\Calculation;
use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class IndexTest extends DuskTestCase
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
    public function testCanSeeListOfCalculations()
    {
        $user = $this->user;
        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user);
            $browser->visitRoute('calculations.index')
                ->assertSee('Название')
                ->assertSee('Пользователь')
                ->assertSee('Коды')
                ->assertSee('Дата добавления')
                ->assertSee('Дата редактирования')
                ->assertSee('Действие')
                ->assertSee('Посмотреть')
                ->assertSee('Обновить')
                ->assertSee('Удалить');
        });
    }
}

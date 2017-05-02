<?php
declare(strict_types=1);

use Illuminate\Database\Seeder;

class CalculationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Calculation::class, 10)->create();
    }
}
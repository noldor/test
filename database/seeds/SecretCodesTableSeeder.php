<?php
declare(strict_types=1);

use Illuminate\Database\Seeder;

class SecretCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\SecretCode::class, 200)->create();
    }
}
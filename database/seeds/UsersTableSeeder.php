<?php

use Illuminate\Database\Seeder;
use \Illuminate\Database\Connection;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Connection $db)
    {
        $db->table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('wowitispassword')
        ]);

        $db->table('users')->insert([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => bcrypt('wowitispassword')
        ]);
    }
}

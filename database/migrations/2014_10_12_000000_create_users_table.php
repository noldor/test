<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Database\Connection;
use Illuminate\Container\Container;

class CreateUsersTable extends Migration
{
    /**
     * @var Connection
     */
    private $db;

    /**
     * CreateUsersTable constructor.
     */
    public function __construct()
    {
        $this->db = Container::getInstance()->make('db');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->db->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->db->getSchemaBuilder()->dropIfExists('users');
    }
}

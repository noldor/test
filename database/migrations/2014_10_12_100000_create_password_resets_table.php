<?php

use Illuminate\Container\Container;
use Illuminate\Database\Connection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePasswordResetsTable extends Migration
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
        $this->db->getSchemaBuilder()->create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->db->getSchemaBuilder()->dropIfExists('password_resets');
    }
}

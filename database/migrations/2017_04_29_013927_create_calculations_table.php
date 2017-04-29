<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Foundation\Application;

class CreateCalculationsTable extends Migration
{
    /**
     * @var \Illuminate\Database\Connection
     */
    private $db;

    /**
     * CreateUsersTable constructor.
     */
    public function __construct()
    {
        $this->db = Application::getInstance()->make('db');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //$this->db->getSchemaBuilder()->enableForeignKeyConstraints();
        $this->db->getSchemaBuilder()->create('calculations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('source');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            //$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->db->getSchemaBuilder()->dropIfExists('calculations');
    }
}

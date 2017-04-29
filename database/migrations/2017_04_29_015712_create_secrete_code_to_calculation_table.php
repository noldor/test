<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use \Illuminate\Foundation\Application;
use Illuminate\Database\Migrations\Migration;

class CreateSecreteCodeToCalculationTable extends Migration
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
        $this->db->getSchemaBuilder()->create('secrete_code_to_calculation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('calculation_id');
            $table->unsignedInteger('secrete_code_id');
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
        $this->db->getSchemaBuilder()->dropIfExists('secrete_code_to_calculation');
    }
}

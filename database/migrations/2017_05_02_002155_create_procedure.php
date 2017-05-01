<?php

use Illuminate\Database\Connection;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;

class CreateProcedure extends Migration
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
        $this->db = Application::getInstance()->make('db');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->db->unprepared("
        CREATE FUNCTION laravel.preg(content LONGTEXT, expression VARCHAR(255))
            RETURNS TEXT
            BEGIN

                DECLARE countInt INT;
                DECLARE results TEXT;
                SET countInt = 1;
                SET results = '';

                preg_match: WHILE (PREG_CAPTURE( expression , content, 0, countInt) IS NOT NULL) DO
                    SET results = concat(results, '#');
                    SET results = concat(results, PREG_CAPTURE( expression , content, 0, countInt));
                    SET countInt = countInt + 1;
                END WHILE preg_match;

                RETURN results;

            END;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->db->unprepared("DROP FUNCTION IF EXISTS preg;");
    }
}

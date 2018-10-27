<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
            DROP TABLE IF EXISTS time_dimension;
            CREATE TABLE time_dimension (
                  id                      INTEGER PRIMARY KEY,
                  db_date                 DATE NOT NULL,
                  year                    INTEGER NOT NULL,
                  month                   INTEGER NOT NULL,
                  day                     INTEGER NOT NULL,
                  quarter                 INTEGER NOT NULL,
                  week                    INTEGER NOT NULL,
                  day_name                VARCHAR(9) NOT NULL,
                  month_name              VARCHAR(9) NOT NULL,
                  holiday_flag            CHAR(1) DEFAULT 'f',
                  weekend_flag            CHAR(1) DEFAULT 'f',
                  event                   VARCHAR(50),
                  UNIQUE td_ymd_idx (year,month,day),
                  UNIQUE td_dbdate_idx (db_date)
          
          ) Engine=MyISAM;
          
            TRUNCATE TABLE time_dimension;
        ");

        $Fill_Procedure = "
          DROP PROCEDURE IF EXISTS fill_date_dimension;
          DELIMITER //
          CREATE PROCEDURE fill_date_dimension(IN startdate DATE,IN stopdate DATE)
          BEGIN
              DECLARE currentdate DATE;
              SET currentdate = startdate;
              WHILE currentdate < stopdate DO
                  INSERT INTO time_dimension VALUES (
                                  YEAR(currentdate)*10000+MONTH(currentdate)*100 + DAY(currentdate),
                                  currentdate,
                                  YEAR(currentdate),
                                  MONTH(currentdate),
                                  DAY(currentdate),
                                  QUARTER(currentdate),
                                  WEEKOFYEAR(currentdate),
                                  DATE_FORMAT(currentdate,'%W'),
                                  DATE_FORMAT(currentdate,'%M'),
                                  'f',
                                  CASE DAYOFWEEK(currentdate) WHEN 1 THEN 't' WHEN 7 then 't' ELSE 'f' END,
                                  NULL);
                  SET currentdate = ADDDATE(currentdate,INTERVAL 1 DAY);
              END WHILE;
          END;
          //
          DELIMITER ;

          TRUNCATE TABLE time_dimension;
          
          CALL fill_date_dimension('2015-01-01','2030-01-01');
          OPTIMIZE TABLE time_dimension;
        ";
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_dimension');
    }
}

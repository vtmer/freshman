<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitActionGroup extends Migration {

    /**
     * @var string
     */
    protected $tableName = 'actiongroup';

    /**
     * @var array
     *
     */
    protected $fillable = array('action','groupid');
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */

	public function up()
	{
        Schema::create($this->tableName,function($table){
            $table->increments('id');
            $table->string('action',30);
            $table->integer('groupid');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop($this->tableName);
	}

}

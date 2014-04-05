<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Initusergroup extends Migration {

    /**
     * @var string
     */
    protected $tableName = "usergroup";

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName,function($table){
            $table->increments('id');
            $table->integer('group_id');
            $table->integer('user_id');
            $table->string('displayname',30);
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

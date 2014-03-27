<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitUserPermission extends Migration {

    /**
     * @var string
     */
    protected $tableName = 'user_permission';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName,function($table){

            $table->integer('user_id');
            $table->string('permission',20);
            $table->primary('user_id');

            $table->engine = 'InnoDB';
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

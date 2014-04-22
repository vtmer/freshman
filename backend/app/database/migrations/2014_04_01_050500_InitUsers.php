<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class InitUsers extends Migration {

    /**
     * @var string
     */
    protected $tableName = 'users';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName,function($table){
            $table->increments('id');
            $table->string('loginname',50);
            $table->string('displayname',50);
            $table->string('password',128);
            $table->string('remember_token',128);
            $table->timestamps();

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


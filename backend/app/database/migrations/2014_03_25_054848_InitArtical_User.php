<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitArticalUser extends Migration {

    /**
     * @var string
     *
     */
    protected $tableName = 'artical_user';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName,function($table){

            $table->integer('artical_id');
            $table->integer('user_id');

            $table->primary(array('artical_id','user_id'));
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

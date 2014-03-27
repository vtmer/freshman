<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitArtical extends Migration {

/**
     *@var string
     *
     */
    protected $tablename = 'artical';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create($this->tablename,function($table){

		    $table->increments('id');
		    $table->string('title',100);
		    $table->string('see',10);
		    $table->text('content');

		    $table->string('frist',10);
		    $table->timestamps(8);

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
		        Schema::drop($this->tablename);
	}

}

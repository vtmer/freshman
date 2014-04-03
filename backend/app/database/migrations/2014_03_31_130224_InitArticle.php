<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitArticle extends Migration {

/**
     *@var string
     *
     */
    protected $tablename = 'article';

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
		    $table->text('content');

            $table->integer('user_id');
            $table->string('user',50);
		    $table->integer('updown')->default(0);
            $table->integer('see')->default(0);
            $table->integer('active')->default(0);
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
	     Schema::drop($this->tablename);
	}

}

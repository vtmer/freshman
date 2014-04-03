<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitArticleUser extends Migration {

    /**
     * @var string
     *
     */
    protected $tableName = 'article_user';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName,function($table){

            $table->integer('article_id');
            $table->integer('user_id');

            $table->primary(array('article_id','user_id'));
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

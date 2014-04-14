<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitSchoolPartArticle extends Migration {

    /**
     * @var string
     */
    protected $tableName = 'article_schoolpart';

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName,function($table){
            $table->integer('article_id');
            $table->integer('schoolpart_id');
            $table->primary(array('article_id','schoolpart_id'));

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

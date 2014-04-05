<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitAction extends Migration {

    /**
     * @var string
     *
     */
    protected $tableName = 'action';

    /**
     * @var array
     *
     */
    protected $fillable = array('actionname','action');
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create($this->tableName,function($table){
            $table->increments('id');
            $table->string('actionname','30');
            $table->string('action','30');
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

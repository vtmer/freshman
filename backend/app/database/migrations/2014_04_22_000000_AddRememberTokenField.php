<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class AddRememberTokenField extends Migration {

    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('remember_token', 128);
        });
    }

    public function down()
    {
        Schema::dropColumn('remember_token');
    }
}

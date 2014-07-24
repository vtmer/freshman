<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class AddRememberTokenField extends Migration {

    public function up()
    {
        Schema::table('users', function ($table) {
            $table->text('remember_token')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('remember_token');
        });
    }
}

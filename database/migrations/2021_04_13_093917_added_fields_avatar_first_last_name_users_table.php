<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddedFieldsAvatarFirstLastNameUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	Schema::table('users', function (Blueprint $table) {
        	$table->string('avatar')->nullable();
	        $table->dropColumn('name');
	        $table->string('first_name')->nullable();
	        $table->string('last_name')->nullable();
		$table->string('phone')->nullable();
	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
	        $table->dropColumn('avatar');
	        $table->dropColumn('first_name');
	        $table->dropColumn('last_name');
	        $table->string('name')->nullable();
		$table->dropColumn('phone');
	});
    }
}

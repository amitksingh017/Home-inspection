<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspectors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('status')->default(false);
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('membership')->nullable();
            $table->string('address')->nullable();
            $table->integer('region_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('region_id')
                ->references('id')
                ->on('regions')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspectors');
    }
}

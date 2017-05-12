<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_persons', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('client_id')->unsigned();
            $table->string('phone_work')->nullable();
            $table->string('phone_mobile')->nullable();
            $table->string('email')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contact_persons');
    }
}

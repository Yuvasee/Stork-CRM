<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->tinyInteger('status')->unsigned();
            $table->date('action_date');
            $table->integer('action_type_id')->unsigned();
            $table->integer('manager_user_id')->unsigned();
            $table->text('description')->nullable();
            $table->string('tags')->nullable();
            $table->timestamps();
            $table->index('client_id');
            $table->index('action_type_id');
            $table->index('manager_user_id');
            $table->index('action_date');
            $table->index(['status', 'action_date']);
            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade');
            $table->foreign('action_type_id')->references('id')->on('action_types')->onUpdate('cascade');
            $table->foreign('manager_user_id')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('actions');
    }
}

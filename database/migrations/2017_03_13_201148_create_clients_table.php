<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('client_type_id')->unsigned();
            $table->integer('client_status_id')->unsigned();
            $table->integer('client_source_id')->unsigned();
            $table->integer('manager_user_id')->unsigned();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->text('post_address')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('region_code')->nullable();
            $table->string('tags')->nullable();
            $table->text('additional_info')->nullable();
            $table->string('website')->nullable();
            $table->integer('created_by_user_id')->unsigned();
            $table->timestamps();
            $table->index('client_type_id');
            $table->index('client_status_id');
            $table->index('client_source_id');
            $table->index('manager_user_id');
            $table->index('created_by_user_id');
            $table->foreign('client_type_id')->references('id')->on('client_types')->onUpdate('cascade');
            $table->foreign('client_status_id')->references('id')->on('client_statuses')->onUpdate('cascade');
            $table->foreign('client_source_id')->references('id')->on('client_sources')->onUpdate('cascade');
            $table->foreign('manager_user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('created_by_user_id')->references('id')->on('users')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableClientOldNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_old_new', function (Blueprint $table) {
            $table->integer('old_client_id')->unsigned();
            $table->integer('new_client_id')->unsigned();
            $table->primary(['old_client_id', 'new_client_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_old_new');
    }
}

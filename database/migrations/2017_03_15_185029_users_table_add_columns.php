<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('user_role_id')->nullable()->unsigned()->after('remember_token');
            $table->string('phone_number')->nullable()->after('user_role_id');
            $table->date('birthday')->nullable()->after('phone_number');
            $table->text('about')->nullable()->after('birthday');
            $table->date('hired_date')->nullable()->after('about');
            $table->date('fired_date')->nullable()->after('hired_date');
            $table->index('user_role_id');
            $table->foreign('user_role_id')->references('id')->on('user_roles')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_groups', function (Blueprint $table) {
            $table->dropColumn('user_role_id');
            $table->dropColumn('phone_number');
            $table->dropColumn('birthday');
            $table->dropColumn('about');
            $table->dropColumn('hired_date');
            $table->dropColumn('fired_date');
        });
    }
}

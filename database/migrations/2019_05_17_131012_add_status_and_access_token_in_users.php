<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusAndAccessTokenInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('user_status_id')->unsigned()->nullable()->after('remember_token');
            $table->string('access_token', 100)->nullable()->after('remember_token');
            $table->foreign('user_status_id')->references('id')->on('user_statuses');
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
            $table->dropForeign(['user_status_id']);
            $table->dropColumn('user_status_id');
            $table->dropColumn('access_token');
        });
    }
}

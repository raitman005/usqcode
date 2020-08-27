<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetNullableFieldsInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('lastname')->nullable()->change();
            $table->string('firstname')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
            $table->string('real_estate_license_number')->nullable()->change();
            $table->string('company')->nullable()->change();
            $table->string('password')->nullable()->change();
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
            $table->string('lastname')->nullable(false)->change();
            $table->string('firstname')->nullable(false)->change();
            $table->string('phone_number')->nullable(false)->change();
            $table->string('real_estate_license_number')->nullable(false)->change();
            $table->string('company')->nullable(false)->change();
            $table->string('password')->nullable(false)->change();
        });
    }
}

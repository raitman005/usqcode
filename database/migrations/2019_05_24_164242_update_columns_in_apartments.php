<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnsInApartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->string('landlord')->nullable()->change();
            $table->dateTime('rented_at')->nullable();
            $table->string('zip_code')->nullable()->after('street');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apartments', function (Blueprint $table) {
            $table->string('landlord')->nullable()->change();
            $table->dropColumn('rented_at');
            $table->dropColumn('zip_code');
        });
    }
}

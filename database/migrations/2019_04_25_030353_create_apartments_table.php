<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->increments('id');
            $table->float('price');
            $table->string('bedrooms');
            $table->string('bathrooms');
            $table->string('apartment_number');
            $table->string('street');
            $table->string('state_id');
            $table->string('city')->default("New York City");
            $table->float('latitude', 12, 7)->nullable();
            $table->float('longitude', 12, 7)->nullable();
            $table->string('landlord', 300);
            $table->mediumText('description')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('available_date');
            $table->foreign('state_id')->references('id')->on('states');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250)->nullable();
            $table->string('phone', 250)->nullable();
            $table->string('ci_number', 250)->nullable();
            $table->string('place_of_issuance_of_ci', 250)->nullable();
            $table->date('date_of_issuance_of_ci', 250)->nullable();
            $table->date('dob')->nullable();
            $table->string('email', 250)->nullable();
            $table->string( 'address', 250)->nullable();
            $table->string( 'city')->nullable();
            $table->string('district')->nullable();
            $table->string('commune')->nullable();
            $table->string('avatar')->nullable();
            $table->string('images')->nullable();
            $table->string('detail')->nullable();
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
        Schema::dropIfExists('clients');
    }
}

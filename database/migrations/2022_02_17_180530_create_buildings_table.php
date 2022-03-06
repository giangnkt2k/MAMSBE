<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250)->nullable();
            $table->string( 'address', 250)->nullable();
            $table->integer( 'type_building')->nullable();
            $table->integer( 'rental_form')->nullable();
            $table->string( 'city')->nullable();
            $table->string('district')->nullable();
            $table->string('commune')->nullable();
            $table->integer('e_money_1kwh')->nullable();
            $table->integer('w_money_1block')->nullable();
            $table->date('date_record_ew')->nullable();
            $table->date('date_charge')->nullable();
            $table->json('utilities')->nullable();
            $table->json('rules')->nullable();
            $table->string('images')->nullable();
            $table->string('detail')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buildings');
    }
}
